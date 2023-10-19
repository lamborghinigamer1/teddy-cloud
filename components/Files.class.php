<?php

class Files extends Database
{
    private string $filepath;
    private string $filetype;
    private string $filename;
    public function __construct()
    {
        parent::__construct();
        $uploaddir = "uploads";

        if (!empty($_FILES['uploadfile']['name'])) {
            $files = $_FILES['uploadfile'];

            for ($i = 0; $i < count($files['name']); $i++) {
                $this->filename = $this->generateRandomString() . $files['name'][$i];
                $this->filepath = $uploaddir . DIRECTORY_SEPARATOR . $this->filename;
                $this->filetype = $files['type'][$i];

                if (move_uploaded_file($files['tmp_name'][$i], $this->filepath)) {
                    $this->addFileToDB();
                } else {
                    echo "File upload failed for {$files['name'][$i]}.";
                }
            }
        } else {
            echo "No files uploaded.";
        }
        header("location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
    private function generateRandomString(): string
    {
        $length = 69;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_'; // All characters that can be generated
        $randomString = ''; // Defined a variable to put the string in
        $bytes = random_bytes($length); // Generate random bytes based on the length in the function
        for ($i = 0; $i < $length; $i++) { // Loop the amount of random charaters based on the length of the function
            $randomString .= $characters[ord($bytes[$i]) % strlen($characters)]; // The random bytes gets converted and gets assigned a character based on the byte
        }
        return $randomString; // This is the final string
    }
    private function getFileSize(): int
    {
        return filesize($this->filepath);
    }
    private function addFileToDB()
    {
        $query = "INSERT INTO files(userid, trash, filename, filesize, filelocation, filetype) VALUES (:userid, :trash, :filename, :filesize, :filelocation, :filetype);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "userid" => $_SESSION['userid'],
            "trash" => 0,
            "filename" => $this->filename,
            "filesize" => $this->getFileSize(),
            "filelocation" => $this->filepath,
            "filetype" => $this->filetype
        ]);
    }
}
