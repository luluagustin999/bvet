<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class CopyLanding extends BaseCommand
{
  protected $group = 'Landing';
  protected $name = 'landing:copy';
  protected $description = 'Copies a module and renames it. Usage: module:copy <sourceModule> <destinationModule> <searchString> <replaceString>';

  public function run(array $params)
  {
    // Check if we have enough parameters
    if (count($params) < 3) {
      CLI::error('Insufficient parameters. Usage: module:copy <sourceModule> <destinationModule> <searchString> <replaceString>');
      return;
    }

    [$sourceModule, $destinationModule, $title] = $params;

    $sourceDir = APPPATH . 'Controllers/' . $sourceModule . '.php';
    $destinationDir = APPPATH . 'Controllers/' . $destinationModule . '.php';

    $this->copyFile($sourceDir, $destinationDir);
    $this->findAndReplaceInFiles($destinationDir, $sourceModule, $destinationModule, $title);

    CLI::write('Module copied and modified successfully.', 'green');
  }

  private function copyFile($src, $dst)
  {
    // Check if source file exists
    if (file_exists($src)) {
      // Copy the file from src to dst
      copy($src, $dst);
    } else {
      // Optionally handle the error, e.g., throw an exception or return false
      echo "Source file does not exist.";
    }
  }

  private function findAndReplaceInFiles($file, $oldString, $newString, $title)
  {
    // Iterate through all files in the directory

    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
      $contents = file_get_contents($file);

      // First, replace the exact case version of the strings
      $contents = str_replace($oldString, $newString, $contents);


      // Target pattern for replacement
      $targetPattern = "'title' => 'SEJARAH'";
      $replacementPattern = "'title' => '" . $title . "'";

      // Replace the exact case version of the target pattern
      $contents = str_replace($targetPattern, $replacementPattern, $contents);

      file_put_contents($file, $contents);
    }
  }
}
