<?php

// Diretórios base dos pacotes
$baseDirs = [
    'MicrosoftAzure\Storage\Blob' => __DIR__ . '/azure-storage/azure-storage-blob/src/blob',
    'MicrosoftAzure\Storage\Common' => __DIR__ . '/azure-storage/azure-storage-common/src/common',
    // Adicione outros diretórios conforme necessário
];

// Autoload básico para carregar classes do SDK
spl_autoload_register(function ($class) use ($baseDirs) {
    // Procura o namespace base
    foreach ($baseDirs as $prefix => $baseDir) {
        // Verifica se a classe usa o namespace prefixo
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Pega o nome relativo da classe
        $relativeClass = substr($class, $len);

        // Substitui o namespace prefixo pelo diretório base, substitui namespace
        // separadores por separadores de diretório no nome relativo da classe,
        // e adiciona .php
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        // Se o arquivo existir, inclua-o
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

// Teste se a classe está sendo carregada
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

// Resto do seu código...


// Configurações de exibição de erros (para debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurações do Azure Blob Storage
$connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
$containerName = "prova2";

// Verifica se o formulário foi enviado e se há um arquivo de imagem
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    // Caminho absoluto da pasta de upload
    $uploadDir = __DIR__ . '/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

    // Verifica se a pasta de uploads existe
    if (!is_dir($uploadDir)) {
        echo "A pasta de uploads não existe.";
        exit;
    }

    // Verifica se houve erro no upload
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "Erro no upload: " . $_FILES['image']['error'];
        exit;
    }

    // Verifica se a imagem foi enviada corretamente
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        echo "Imagem enviada com sucesso!<br>";

        // Enviar para o Azure Blob Storage
        try {
            $blobClient = BlobRestProxy::createBlobService($connectionString);
            $content = fopen($uploadFile, "r");
            $options = new CreateBlockBlobOptions();
            $options->setContentType(mime_content_type($uploadFile));

            $blobClient->createBlockBlob($containerName, basename($_FILES['image']['name']), $content, $options);
            echo "Imagem enviada para o Azure Blob Storage!<br>";
        } catch(ServiceException $e){
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo "Erro ao enviar para o Azure Blob Storage: $error_message";
        }

        // Agora que o arquivo foi enviado, enviaremos para a API da Azure
        $endpoint = 'https://reconhecimentoprova2.cognitiveservices.azure.com/face/v1.0/detect';
        $key = '6JXH8i0huVYzbFf1q4I1OAlmhgC9aJKLAbW11lx93AAO6JplIMCrJQQJ99AKACZoyfiXJ3w3AAAKACOGwjts';

        // Inicializa o cURL
        $ch = curl_init();

        // Configura o cURL
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        // Cabeçalhos exigidos pela Azure
        $headers = [
            'Ocp-Apim-Subscription-Key: ' . $key,
            'Content-Type: application/octet-stream',
        ];

        // Define os cabeçalhos
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Envia o arquivo de imagem diretamente para a API
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($uploadFile));

        // Executa a requisição e captura a resposta
        $response = curl_exec($ch);

        // Verifica se ocorreu erro no cURL
        if (curl_errno($ch)) {
            echo 'Erro cURL: ' . curl_error($ch);
        } else {
            // Formata e exibe a resposta da Azure de forma amigável
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $jsonResponse = json_decode($response, true);
                echo "<br>Resposta da Azure (detecção de rosto): <pre>";
                print_r($jsonResponse);
                echo "</pre>";
            } else {
                echo "Erro na resposta da Azure: " . $response;
            }
        }

        // Fecha a conexão cURL
        curl_close($ch);
    } else {
        echo "Erro no upload da imagem.";
    }
} else {
    echo "Nenhuma imagem enviada.";
}
?>
