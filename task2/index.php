<?php
function decrypt($data, $password) {
    // Decode the base64 encoded string
    $data = base64_decode($data);
    
    // Create the key from the password using md5
    $key = md5($password, true);
    
    // Extract the initialization vector (IV) from the first 16 bytes of the data
    // $iv = substr($data, 0, 16);
    $iv = "0000000000000000";
    
    // Extract the encrypted data
    $encrypted_data = substr($data, 16);
    
    // Decrypt the data using OpenSSL
    $decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    
    return $decrypted_data;
}

$encrypted_string = 'OtSrzlB7n3MjD01XlzM4MfNeam1Z-oCnO3kEkxptuS4';
$password = 'automaze';

$decrypted_value = decrypt($encrypted_string, $password);
echo "Decrypted value: " . $decrypted_value;
?>
