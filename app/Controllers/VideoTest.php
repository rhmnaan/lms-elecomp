<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class VideoTest extends BaseController
{
    public function testEncryption()
    {
        $key = (string) env('VIDEO_ENCRYPTION_KEY', '');
        
        if (empty($key)) {
            die('VIDEO_ENCRYPTION_KEY tidak ditemukan');
        }

        echo "<h2>Test Enkripsi AES-256-CBC</h2>";
        echo "Key: " . $key . "<br>";
        echo "Key length: " . strlen($key) . " bytes<br><br>";

        // Derive 32-byte key
        $derivedKey = hash('sha256', $key, true);
        echo "Derived key length: " . strlen($derivedKey) . " bytes<br><br>";

        // Test data
        $testData = "Hello World! This is a test video data.";
        echo "Original data: " . $testData . "<br>";
        echo "Original length: " . strlen($testData) . " bytes<br><br>";

        // Generate IV
        $iv = openssl_random_pseudo_bytes(16);
        echo "IV length: " . strlen($iv) . " bytes<br><br>";

        // Encrypt
        $encrypted = openssl_encrypt(
            $testData,
            'aes-256-cbc',
            $derivedKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($encrypted === false) {
            die('Enkripsi GAGAL: ' . openssl_error_string());
        }

        echo "✅ Enkripsi berhasil<br>";
        echo "Encrypted length: " . strlen($encrypted) . " bytes<br><br>";

        // Simulasi format file .enc (IV + ciphertext)
        $fileContent = $iv . $encrypted;
        echo "File .enc length (IV + ciphertext): " . strlen($fileContent) . " bytes<br><br>";

        // Decrypt (simulasi browser)
        $ivFromFile = substr($fileContent, 0, 16);
        $ciphertext = substr($fileContent, 16);

        echo "IV from file length: " . strlen($ivFromFile) . " bytes<br>";
        echo "Ciphertext length: " . strlen($ciphertext) . " bytes<br><br>";

        $decrypted = openssl_decrypt(
            $ciphertext,
            'aes-256-cbc',
            $derivedKey,
            OPENSSL_RAW_DATA,
            $ivFromFile
        );

        if ($decrypted === false) {
            die('❌ Dekripsi GAGAL: ' . openssl_error_string());
        }

        echo "✅ Dekripsi berhasil<br>";
        echo "Decrypted data: " . $decrypted . "<br>";
        echo "Match: " . ($decrypted === $testData ? '✅ YA' : '❌ TIDAK') . "<br><br>";

        // Test dengan base64 (seperti di browser)
        echo "<hr><h3>Test Browser Simulation (Base64)</h3>";
        $keyBase64 = base64_encode($derivedKey);
        echo "Key base64: " . $keyBase64 . "<br><br>";

        echo "<script>
        console.log('=== Browser Test ===');
        
        const keyB64 = '" . $keyBase64 . "';
        const ivHex = '" . bin2hex($iv) . "';
        const encHex = '" . bin2hex($encrypted) . "';
        
        console.log('Key (base64):', keyB64);
        console.log('IV (hex):', ivHex);
        console.log('Encrypted (hex):', encHex);
        
        // Convert hex to ArrayBuffer
        function hexToBuffer(hex) {
            const arr = new Uint8Array(hex.length / 2);
            for (let i = 0; i < hex.length; i += 2) {
                arr[i / 2] = parseInt(hex.substr(i, 2), 16);
            }
            return arr.buffer;
        }
        
        // Convert base64 to ArrayBuffer
        function b64ToBuffer(b64) {
            const bin = atob(b64);
            const arr = new Uint8Array(bin.length);
            for (let i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
            return arr.buffer;
        }
        
        async function testDecrypt() {
            try {
                // Import key
                const keyBuffer = b64ToBuffer(keyB64);
                const cryptoKey = await crypto.subtle.importKey(
                    'raw',
                    keyBuffer,
                    { name: 'AES-CBC' },
                    false,
                    ['decrypt']
                );
                console.log('✅ Key imported');
                
                // Decrypt
                const ivBuffer = hexToBuffer(ivHex);
                const encBuffer = hexToBuffer(encHex);
                
                const decrypted = await crypto.subtle.decrypt(
                    { name: 'AES-CBC', iv: new Uint8Array(ivBuffer) },
                    cryptoKey,
                    encBuffer
                );
                
                const text = new TextDecoder().decode(decrypted);
                console.log('✅ Dekripsi berhasil:', text);
                console.log('Match:', text === '" . $testData . "');
                
                document.getElementById('browserResult').innerHTML = 
                    '✅ Browser dekripsi berhasil!<br>Decrypted: ' + text;
                
            } catch (err) {
                console.error('❌ Browser dekripsi gagal:', err);
                document.getElementById('browserResult').innerHTML = 
                    '❌ Error: ' + err.message;
            }
        }
        
        testDecrypt();
        </script>";

        echo "<div id='browserResult' style='padding:10px; background:#f0f0f0; margin-top:20px;'>
            Menunggu hasil dekripsi browser...
        </div>";
    }
}