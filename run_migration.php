<?php
require_once './classes/Database.php';

$db = Database::getInstance()->getConnection();


$folderPath = './migrations';

$create_migration_table = "CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$query = $db->exec($create_migration_table);

function checkIfExists($db, $migration_name) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM migrations WHERE migration_name = :migration_name");
    $stmt->bindParam(':migration_name', $migration_name);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function insertMigration($db, $migration_name) {
    $stmt = $db->prepare("INSERT INTO migrations (migration_name) VALUES (:migration_name)");
    $stmt->bindParam(':migration_name', $migration_name);
    return $stmt->execute();
}


try {
    $files = scandir($folderPath);

    foreach($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'sql') {
            echo "Running: $file\n";

            $ifExists = checkIfExists($db, $file);
            echo "Checking if migration exists: $file\n";
            echo "Exists: " . ($ifExists ? 'Yes' : 'No') . "\n";
            if ($ifExists) {
                continue;
            }
            insertMigration($db, $file);
            $sql = file_get_contents($filePath);
            $db->exec($sql);
            echo "Success: $file\n";
        }
        
    }
    echo "All migrations have been executed successfully.\n";
} catch( PDOException $e ) {
    die("Error scanning directory: " . $e->getMessage());
}catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}


?>