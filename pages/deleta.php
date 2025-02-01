<?php

function deleteDir($dirPath)
{
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

$vendorDir = __DIR__ . '/vendor';
if (is_dir($vendorDir)) {
    deleteDir($vendorDir);
    echo 'Diretório vendor removido com sucesso!';
} else {
    echo 'Diretório vendor não encontrado.';
}
