<?php namespace O;
#@+leo-ver=5-thin
#@+node:caminhante.20240327153006.1: * @file FileClass.php
#@@first
#@@language plain
#@+others
#@+node:caminhante.20260510145000.1: ** /includes
// s()
if (!class_exists("\\O\\StringClass")) { include("StringClass.php"); }
// a()
if (!class_exists("\\O\\ArrayClass")) { include("ArrayClass.php"); }
// d()
if (!class_exists("\\O\\DateTime")) { include("DateTime.php"); }
#@+node:caminhante.20240327153013.1: ** class FileClass
class FileClass {
  private const link = 0120000;
  private const file = 0100000;
  private const block = 0060000;
  private const directory = 0040000;
  private const fifo = 0010000;
  private StringClass $filename;
  private array|string $pathinfo;
  private $filehandle = false;
  private string $openmode = '';
  #@+others
  #@+node:caminhante.20240327153013.2: *3* function __construct ($filename)
  function __construct (&$filename) {
    $this->filename = s($filename);
    $this->pathinfo = pathinfo($filename);
  }
  #@+node:caminhante.20240327153013.3: *3* static function get_straight_path ($path)
  // Returns a relative path that go straight to the target
  static function get_straight_path (string $path): string {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
      if ('.' == $part) { continue; }
      if ('..' == $part) { array_pop($absolutes); }
      else { $absolutes[] = $part; } }
    return implode(DIRECTORY_SEPARATOR, $absolutes);
  }
  #@+node:caminhante.20240327153013.4: *3* static function current_dir ()
  // Directory of the current script
  static function current_dir (): string {
    return dirname(__FILE__);
  }
  #@+node:caminhante.20260510151918.1: *3* static function formatted_length ()
  static function formatted_length (int $size): string {
    if ($size == 0) { return '0 B'; }
    $base = log($size, 1024);
    $suffixes = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
    return round(pow(1024, $base-floor($base)), 2).' '.$suffixes[floor($base)];
  }
  #@+node:caminhante.20240327153013.6: *3* static function separator ()
  static function separator (): string {
    return DIRECTORY_SEPARATOR;
  }
  #@+node:caminhante.20240327153013.5: *3* Informations
  #@+node:caminhante.20240327153013.7: *4* public function is_directory ()
  public function is_directory (): bool {
    return is_dir($this->filename);
  }
  #@+node:caminhante.20240327153013.8: *4* public function is_file ()
  public function is_file (): bool {
    return is_file($this->filename);
  }
  #@+node:caminhante.20240327153013.9: *4* public function parent ()
  // The directory containing this file/directory
  public function parent (): StringClass {
    return s($this->pathinfo['dirname']);
  }
  #@+node:caminhante.20240327153013.10: *4* public function path ()
  // Canonical path to file/directory
  public function path (): StringClass {
    if ($this->exists()) { return s(realpath($this->filename)); }
    return s(realpath($this->parent()) . FileClass::separator() . $this->name());
  }
  #@+node:caminhante.20240327153013.11: *4* public function name ()
  public function name (): StringClass {
    return s($this->pathinfo['basename']);
  }
  #@+node:caminhante.20240327153013.12: *4* public function relative_name ()
  public function relative_name (): StringClass {
    return $this->filename;
  }
  #@+node:caminhante.20240327153013.13: *4* public function extension ()
  public function extension (): StringClass {
    return s($this->pathinfo['extension']);
  }
  #@+node:caminhante.20240327153013.14: *4* public function length ()
  // Length of bytes on file or number of entries on a directory
  public function length (): int {
    if ($this->is_directory()) {
      $dirlist = scandir($this->filename, SCANDIR_SORT_NONE);
      return a($dirlist)->count() - 2; }
    if ($this->is_file()) {
      return filesize($this->filename); }
    return -1;
  }
  #@+node:caminhante.20240327153013.15: *4* public function exists ()
  public function exists (): bool {
    return file_exists($this->filename);
  }
  #@+node:caminhante.20240327153013.16: *4* public function is_open ()
  public function is_open (): bool {
    return $filehandle != false;
  }
  #@+node:caminhante.20240327153013.17: *4* public function is_uploaded ()
  public function is_uploaded (): bool {
    return is_uploaded_file($this->filename);
  }
  #@+node:caminhante.20240327153013.18: *4* public function can_read ()
  public function can_read (): bool {
    return is_readable($this->filename);
  }
  #@+node:caminhante.20240327153013.19: *4* public function can_write ()
  public function can_write (): bool {
    return is_writable($this->filename);
  }
  #@+node:caminhante.20240327153013.20: *4* public function creation_time ()
  public function creation_time (): DateTime {
    return d(filectime($this->filename));
  }
  #@+node:caminhante.20240327153013.21: *4* public function last_modified ()
  public function last_modified (): DateTime {
    return d(filemtime($this->filename));
  }
  #@+node:caminhante.20240327153013.22: *4* public function last_accessed ()
  public function last_accessed (): DateTime {
    return d(fileatime($this->filename));
  }
  #@+node:caminhante.20240327153013.23: *4* public function position ()
  // The file pointer position
  public function position (): int|false {
    if (!$this->filehandle) { return -1; }
    return ftell($this->filehandle);
  }
  #@+node:caminhante.20240327153013.24: *4* public function mode ()
  // A string describing the mode used to open the file
  public function mode () {
    return $this->openmode;
  }
  #@+node:caminhante.20240327153013.25: *3* Manipulations
  #@+node:caminhante.20240327153013.26: *4* public function open ($mode)
  public function open (string $mode): bool {
    if ($this->filehandle) { return true; }
    if ($this->is_directory()) {
      $this->openmode = "d";
      $this->filehandle = opendir($this->filename);
    } else {
      $this->openmode = $mode;
      $this->filehandle = fopen($this->filename, $mode);
    }
    if (!$this->filehandle) { $this->openmode = ''; }
    return ($this->filehandle != false);
  }
  #@+node:caminhante.20240327153013.27: *4* public function open_rw ()
  public function open_rw (): bool {
    return $this->open("c+b");
  }
  #@+node:caminhante.20240327153013.28: *4* public function close ()
  public function close (): void {
    if (!$this->filehandle) { return; }
    if ($this->is_directory()) { closedir($this->filehandle); }
    else if ($this->is_file()) { fclose($this->filehandle); }
    $this->filehandle = false;
    $this->openmode = '';
  }
  #@+node:caminhante.20240327153013.29: *4* public function remove ()
  public function remove (): bool {
    if ($this->filehandle) { $this->close(); }
    if ($this->is_file()) { return unlink($this->filename); }
    else if ($this->is_directory()) { return rmdir($this->filename); }
    return false;
  }
  #@+node:caminhante.20240327153013.30: *4* public function copy_to ($target)
  public function copy_to (string $target): bool {
    $this->flush();
    return copy($this->filename, $target);
  }
  #@+node:caminhante.20240327153013.31: *4* public function rename_to ($target)
  public function rename_to (string $target): bool {
    if ($this->filehandle) { $this->close(); }
    $r = rename($this->filename, $target);
    if ($r) {
      $this->filename = s($target);
      $this->pathinfo = pathinfo($target); }
    return $r;
  }
  #@+node:caminhante.20240327153013.32: *4* public function seek ($pos = 0, $whence = SEEK_CUR)
  public function seek (int $pos = 0, int $whence = SEEK_CUR): false|int {
    if (!$this->filehandle) { return false; }
    if ($this->is_file()) { return fseek($this->filehandle, $pos, $whence); }
    return false;
  }
  #@+node:caminhante.20240327153013.33: *4* public function rewind ()
  public function rewind (): bool {
    if (!$this->filehandle) { return false; }
    if ($this->is_file()) { return rewind($this->filehandle); }
    if ($this->is_directory()) { rewinddir($this->filehandle); return true; }
    return false;
  }
  #@+node:caminhante.20240327153013.34: *4* public function read ($bytes = 1)
  public function read ($bytes = 1): false|string {
    if (!$this->filehandle) { return false; }
    if ($this->is_file()) { return fread($this->filehandle, $bytes); }
    if ($this->is_directory()) { return readdir($this->filehandle); }
    return false;
  }
  #@+node:caminhante.20240327153013.35: *4* public function readln ()
  public function readln (): false|string {
    if (!$this->filehandle) { return false; }
    if ($this->is_file()) { return fgets($this->filehandle); }
    if ($this->is_directory()) { return readdir($this->filehandle); }
    return false;
  }
  #@+node:caminhante.20240327153013.36: *4* public function read_all ()
  public function read_all (): false|string {
    if (!$this->filehandle) { return false; }
    $this->rewind();
    if ($this->is_file()) { return $this->read($this->length()); }
    if ($this->is_directory()) {
      $r = '';
      for ($i = 1; $i <= $this->length(); $i++) { $r .= readdir($this->filehandle) . "\n"; }
      return $r;
    }
    return false;
  }
  #@+node:caminhante.20240327153013.37: *4* public function write ($str)
  public function write ($str): false|int {
    if (!$this->filehandle) { return false; }
    if ($this->is_file()) { return fwrite($this->filehandle, $str); }
    return false;
  }
  #@+node:caminhante.20240327153013.38: *4* public function write_all ($lines)
  public function write_all ($lines): false|int {
    if (!$this->filehandle) { return false; }
    if ($this->is_file()) { 
      ftruncate($this->filehandle, 0);
      rewind($this->filehandle);
      $r = 0;
      foreach ($lines as $line) {
        $l = $this->write($line);
        if ($l != count($line)) { return $r; }
        $r += $l;
      }
      return $r;
    }
    return false;
  }
  #@+node:caminhante.20240327153013.39: *4* public function flush ()
  public function flush (): bool {
    if (!$this->filehandle) { return false; }
    if ($this->is_file()) { return fflush($this->filehandle); }
    return false;
  }
  #@+node:caminhante.20240327153013.40: *4* public function list ($pattern = '*')
  public function list ($pattern = '*'): array|false {
    $dir = $this->parent();
    if ($this->is_directory() && $this->exists()) { $dir = $this->name(); }
    return glob($dir . FileClass::separator() . $pattern, GLOB_MARK & GLOB_NOSORT & GLOB_BRACE);
  }
  #@+node:caminhante.20240327153013.41: *4* public function mkdir ($name = false)
  public function mkdir (string $name = '', int $mode = 0777): bool {
    if (count($name) == 0 && !$this->exists()) {
      return mkdir($this->filename, $mode, true);
    }
    $dir = $this->parent();
    if ($this->is_directory() && $this->exists()) { $dir = $this->name(); }
    return mkdir($dir . static::separator() . $name, $mode, true);
  }
  #@+node:caminhante.20240327153013.42: *4* public function mkfile ($name)
  public function mkfile (string $name): bool {
    $dir = $this->parent();
    if ($this->is_directory() && $this->exists()) { $dir = $this->name(); }
    return touch($dir . static::separator() . $name);
  }
  #@+node:caminhante.20240327153013.43: *3* Locks
  #@+node:caminhante.20240327153013.44: *4* public function lock_exclusive ()
  public function lock_exclusive (): bool {
    if ($this->is_directory()) { return false; }
    if (!$this->filehandle) { $this->open_rw(); }
    return ( $this->filehandle &&
      flock($this->filehandle, LOCK_EX|LOCK_NB, $eWouldBlock) &&
      $eWouldBlock == 0 );
  }
  #@+node:caminhante.20240327153013.45: *4* public function lock_shared ()
  public function lock_shared (): bool {
    if ($this->is_directory()) { return false; }
    if (!$this->filehandle) { $this->open_rw(); }
    return ( $this->filehandle &&
      flock($this->filehandle, LOCK_SH|LOCK_NB, $eWouldBlock) &&
      $eWouldBlock == 0 );
  }
  #@+node:caminhante.20240327153013.46: *4* public function unlock ()
  public function unlock (): void {
    if ($this->filehandle) { $this->close(); }
  }
  #@-others
}
#@+node:caminhante.20240327153051.1: ** function f
/**
 * @param mixed $f
 * @return \O\FileClass
 */
function f ($p) {
  if ($p instanceof FileClass) { return $p; }
  else { return new FileClass($p); }
}
#@-others
#@-leo
