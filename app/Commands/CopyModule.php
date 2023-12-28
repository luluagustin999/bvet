<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class CopyModule extends BaseCommand
{
  protected $group = 'Modules';
  protected $name = 'module:copy';
  protected $description = 'Copies a module and renames it. Usage: module:copy <sourceModule> <destinationModule> <searchString> <replaceString>';

  public function run(array $params)
  {
    // Check if we have enough parameters
    if (count($params) < 4) {
      CLI::error('Insufficient parameters. Usage: module:copy <sourceModule> <destinationModule> <searchString> <replaceString>');
      return;
    }

    [$sourceModule, $destinationModule, $searchString, $replaceString] = $params;

    $sourceDir = APPPATH . 'Modules/' . $sourceModule;
    $destinationDir = APPPATH . 'Modules/' . $destinationModule;

    $this->copyFolder($sourceDir, $destinationDir);
    $this->renameFiles($destinationDir, $searchString, $replaceString);
    $this->findAndReplaceInFiles($destinationDir, $searchString, $replaceString);
    $this->addPermissionsToAuthGroups($replaceString);

    CLI::write('Module copied and modified successfully.', 'green');
  }

  private function copyFolder($src, $dst)
  {
    $dir = opendir($src);
    @mkdir($dst);
    while (($file = readdir($dir)) !== false) {
      if (($file != '.') && ($file != '..')) {
        if (is_dir($src . '/' . $file)) {
          $this->copyFolder($src . '/' . $file, $dst . '/' . $file);
        } else {
          copy($src . '/' . $file, $dst . '/' . $file);
        }
      }
    }
    closedir($dir);
  }

  private function renameFiles($dir, $searchString, $replaceString)
  {
    $filesToRename = [
      'Controllers/' . $searchString . 'Controller.php' => 'Controllers/' . $replaceString . 'Controller.php',
      'Database/Migrations/2023-04-30-101748_Create' . $searchString . 'Table.php' => 'Database/Migrations/2023-04-30-101748_Create' . $replaceString . 'Table.php',
      'Language/en/' . $searchString . '.php' => 'Language/en/' . $replaceString . '.php',
      'Models/' . $searchString . 'Model.php' => 'Models/' . $replaceString . 'Model.php',
    ];

    foreach ($filesToRename as $oldFile => $newFile) {
      rename($dir . '/' . $oldFile, $dir . '/' . $newFile);
    }
  }

  private function findAndReplaceInFiles($dir, $oldString, $newString)
  {
    // Lowercase versions of the old and new strings
    $oldStringLowercase = strtolower($oldString);
    $newStringLowercase = strtolower($newString);

    // Iterate through all files in the directory
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
      if ($file->isFile() && $file->getExtension() === 'php') {
        $contents = file_get_contents($file->getPathname());

        // First, replace the exact case version of the strings
        $contents = str_replace($oldString, $newString, $contents);

        // Second, replace the lowercase version of the strings
        $contents = str_replace($oldStringLowercase, $newStringLowercase, $contents);

        file_put_contents($file->getPathname(), $contents);
      }
    }
  }

  private function addPermissionsToAuthGroups($moduleName)
  {
    $authGroupsFilePath = APPPATH . 'Config/AuthGroups.php';
    $moduleNameLowerCase = strtolower($moduleName);
    // Check if AuthGroups.php exists
    if (file_exists($authGroupsFilePath)) {
      $contents = file_get_contents($authGroupsFilePath);

      // Permissions to add
      $permissionsToAdd = [
        "'$moduleNameLowerCase.view' => 'Can view pages details',",
        "'$moduleNameLowerCase.create' => 'Can create new pages',",
        "'$moduleNameLowerCase.edit' => 'Can edit existing pages',",
        "'$moduleNameLowerCase.delete' => 'Can delete existing pages',",
        "'$moduleNameLowerCase.settings' => 'Can manage pages settings in admin area',"
      ];

      // Pattern to identify the end of the $permissions array
      $pattern = '/(public\s+array\s+\$permissions\s*=\s*\[[\s\S]*?)];/m';

      // Replace the pattern with new permissions added before the closing bracket
      $contents = preg_replace($pattern, '$1' . implode("\n    ", $permissionsToAdd) . "\n];", $contents);

      // Pattern to identify the 'superadmin' key in the $matrix array
      $patternsuperadmin = "/('superadmin'\s*=>\s*\[[\s\S]*?)(\],\s*'admin')/m";

      // New permission to add
      $permissionToAdd = "'$moduleNameLowerCase.*',";

      // Replace the pattern by adding new permission before the closing bracket of 'superadmin' key
      $contents = preg_replace($patternsuperadmin, '$1' . $permissionToAdd . "\n    $2", $contents);


      file_put_contents($authGroupsFilePath, $contents);
    } else {
      CLI::error("The file $authGroupsFilePath does not exist.");
    }
  }
}
