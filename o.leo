<?xml version="1.0" encoding="utf-8"?>
<!-- Created by Leo: http://leoeditor.com/leo_toc.html -->
<leo_file xmlns:leo="http://leoeditor.com/namespaces/leo-python-editor/1.1" >
<leo_header file_format="2"/>
<globals/>
<preferences/>
<find_panel_settings/>
<vnodes>
<v t="caminhante.20200313155940.1"><vh>@settings</vh>
<v t="caminhante.20200618180759.1"><vh>@command terminal-here @key=Alt-T</vh></v>
<v t="caminhante.20200828195842.1"><vh>@data abbreviations</vh></v>
<v t="caminhante.20200313155940.4"><vh>@outline-data tree-abbreviations</vh></v>
<v t="caminhante.20200313155940.99"><vh>nodeActions</vh>
<v t="caminhante.20200604232050.1"><vh>@cmd *</vh></v>
<v t="caminhante.20211012181130.1"><vh>@cp *</vh></v>
<v t="caminhante.20200619161501.1"><vh>@download *</vh></v>
<v t="caminhante.20200619155412.1"><vh>@duck *</vh></v>
<v t="caminhante.20200927204806.1"><vh>@gcc|@gcc .* [X]</vh></v>
<v t="caminhante.20200808174417.1"><vh>@js|@js .* [X]</vh></v>
<v t="caminhante.20200912185313.1"><vh>@lua|@lua .* [X]</vh></v>
<v t="caminhante.20210501142945.2"><vh>@mkdir *</vh></v>
<v t="caminhante.20210501142945.3"><vh>@mv file://*</vh></v>
<v t="caminhante.20211012180812.1"><vh>@mv *</vh></v>
<v t="caminhante.20200619213937.1"><vh>@node|@node .* [X]</vh></v>
<v t="caminhante.20210905232208.1"><vh>@rm *</vh></v>
<v t="caminhante.20210501142945.4"><vh>@rmdir /*/</vh></v>
<v t="caminhante.20200618203115.1"><vh>@run|@run .* [X]</vh></v>
<v t="caminhante.20200619154823.1"><vh>@web *</vh></v>
</v>
</v>
<v t="caminhante.20211024192337.2"><vh>PHP-O</vh>
<v t="caminhante.20211024192713.1"><vh>@path .</vh>
<v t="caminhante.20211024192714.8"><vh>/.git/</vh></v>
<v t="caminhante.20211024192714.7"><vh>/src/</vh>
<v t="caminhante.20211024200631.1"><vh>/O/</vh>
<v t="caminhante.20211024200632.10"><vh>@file ArrayClass.php</vh></v>
<v t="caminhante.20211024200632.9"><vh>@file ChainableClass.php</vh></v>
<v t="caminhante.20211024200632.8"><vh>@file DateTime.php</vh></v>
<v t="caminhante.20211024200632.5"><vh>@file PDO.php</vh></v>
<v t="caminhante.20211024200632.4"><vh>@edit ReflectionClass.php</vh></v>
<v t="caminhante.20211024200632.3"><vh>@edit Session.php</vh></v>
<v t="caminhante.20211024200632.2"><vh>@edit StringClass.php</vh>
<v t="caminhante.20220725214947.1"><vh>UTF-8 by default</vh></v>
<v t="caminhante.20220725215630.1"><vh>class StringClass</vh></v>
</v>
<v t="caminhante.20211024200632.7"><vh>@file O.php</vh></v>
<v t="caminhante.20211024200632.6"><vh>@file ObjectClass.php</vh></v>
<v t="caminhante.20211024200632.1"><vh>@file Validator.php</vh></v>
</v>
</v>
<v t="caminhante.20211024192714.6"><vh>/tests/</vh></v>
<v t="caminhante.20211024194321.1"><vh>/vendor/</vh></v>
<v t="caminhante.20211024192714.3"><vh>@auto README.md</vh></v>
<v t="caminhante.20211024194133.1"><vh>@edit .gitignore</vh></v>
<v t="caminhante.20211024192714.2"><vh>@edit composer.json</vh></v>
<v t="caminhante.20211024192714.5"><vh>@edit LICENSE</vh></v>
<v t="caminhante.20211024192714.4"><vh>@edit O.php</vh></v>
<v t="caminhante.20211024194140.2"><vh>composer.lock</vh></v>
<v t="caminhante.20211024194140.1"><vh>o.leo</vh></v>
</v>
</v>
</vnodes>
<tnodes>
<t tx="caminhante.20200313155940.1"></t>
<t tx="caminhante.20200313155940.4"></t>
<t tx="caminhante.20200313155940.99">@language python
</t>
<t tx="caminhante.20200604232050.1">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

if c.isChanged(): c.save()

path = c.getNodePath(c.p)
g.os.chdir(path)

command = ''.join(c.p.h.split('@cmd ')[1:])
command = "cat &lt;&lt;'EOFEOFEOFEOFEOFEOF' | bash\n"+command+'\nEOFEOFEOFEOFEOFEOF'
g.es(c.p.h)
c.p.b += execute(command)

c.save()
</t>
<t tx="caminhante.20200618180759.1">@language python
import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

if c.isChanged(): c.save()
path = c.getNodePath(c.p)

execute('terminator --working-directory="'+path+'"')
</t>
<t tx="caminhante.20200618203115.1">@language python
import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

w = c.frame.body.wrapper
s1,s2 = w.getSelectionRange()

if s1 == s2:
    code = c.p.b
else:
    linebr = c.p.b.find('\n',s2)
    if linebr == -1: linebr = len(c.p.b)
    code = c.p.b[s1:s2]

g.es(c.p.h)

command = "cat &lt;&lt;'EOFEOFEOFEOFEOFEOF' | bash\n"+code+'\nEOFEOFEOFEOFEOFEOF'

cpc = c.p.copy()
novoNo = cpc.insertAsLastChild()
novoNo.h = c.p.h
novoNo.b = execute(command)
c.redraw()

c.save()
w.setSelectionRange(s1,s2)
</t>
<t tx="caminhante.20200619154823.1">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

if c.isChanged(): c.save()

url = ''.join(c.p.h.split('@web ')[1:])
command = 'lynx -image_links -dump "'+url+'"'
g.es(c.p.h)
c.p.b = execute(command)

c.save()
</t>
<t tx="caminhante.20200619155412.1">import subprocess
import urllib.parse

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

if c.isChanged(): c.save()

search = ''.join(c.p.h.split('@duck ')[1:])
searchenc = urllib.parse.quote(search)
command = 'lynx -dump "https://duckduckgo.com/html/?q='+searchenc+'&amp;t=seamonkey"'
g.es(c.p.h)
c.p.b = execute(command)

c.save()
</t>
<t tx="caminhante.20200619161501.1">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

if c.isChanged(): c.save()

path = c.getNodePath(c.p)
g.os.chdir(path)

url = ''.join(c.p.h.split('@download ')[1:])
command = 'wget --no-config --continue --no-verbose --adjust-extension --tries=3 --content-on-error "'+url+'"'
g.es(c.p.h)
c.p.b += execute(command)

c.save()
</t>
<t tx="caminhante.20200619213937.1">import subprocess
import re

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

code = re.sub(r'^#|\s+#', '\n///', g.getScript(c,c.p))

g.es(c.p.h)

command = "cat &lt;&lt;'EOFEOFEOFEOFEOFEOF' | node\n"+code+'\nEOFEOFEOFEOFEOFEOF'

c.p.b += '\n' + execute(command)
</t>
<t tx="caminhante.20200808174417.1">import subprocess
import re

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

code = re.sub(r'^#|\s+#', '\n///', g.getScript(c,c.p))

g.es(c.p.h)

command = "cat &lt;&lt;'EOFEOFEOFEOFEOFEOF' | js\n"+code+'\nEOFEOFEOFEOFEOFEOF'

c.p.b += '\n' + execute(command)
</t>
<t tx="caminhante.20200828195842.1">@tabwidth -2
</t>
<t tx="caminhante.20200912185313.1">import subprocess
import re

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

code = re.sub(r'^#|\s+#', '\n---', g.getScript(c,c.p))

g.es(c.p.h)

command = "cat &lt;&lt;'EOFEOFEOFEOFEOFEOF' | lua\n"+code+'\nEOFEOFEOFEOFEOFEOF'

c.p.b += '\n' + execute(command)
</t>
<t tx="caminhante.20200927204806.1">import subprocess
import re

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

code = re.sub(r'^#@|\s+#@', '\n///', g.getScript(c,c.p))
args = ''.join(c.p.h.split('@gcc ')[1:])

g.es(c.p.h)

command = "cat &lt;&lt;'EOFEOFEOFEOFEOFEOF' | gcc -xc - -Wall -Werror -std=gnu11 -c -o /dev/null \n"+code+'\nEOFEOFEOFEOFEOFEOF'

c.p.b += '\n' + execute(command)
</t>
<t tx="caminhante.20210501142945.2">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

path = ''.join(c.p.h.split('@mkdir ')[1:])
cmd = 'mkdir -p -- "' + path + '"'
g.es(c.p.h)
execute(cmd)
c.p.h = '/'+path+'/'
c.p.b = '@path ' + path
</t>
<t tx="caminhante.20210501142945.3">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

path = ''.join(c.p.h.split('@mv file://')[1:])
cmd = 'mv -v -- "' + path + '" ./'
g.es(c.p.h)
g.es(execute(cmd))
</t>
<t tx="caminhante.20210501142945.4">import subprocess
import shutil

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

ps = c.p.parents()
for par in ps:
    break
path = c.getNodePath(par)
g.os.chdir(path)

path = ''.join(c.p.h.split('@rmdir /')[1:]).split('/')[0]
shutil.rmtree(path)
c.p.b = 'deleted'
</t>
<t tx="caminhante.20210905232208.1">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

filename = ''.join(c.p.h.split('@rm ')[1:])
cmd = 'rm -vf -- "' + filename + '"'
g.es(c.p.h)
g.es(execute(cmd))
</t>
<t tx="caminhante.20211012180812.1">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

path = ''.join(c.p.h.split('@mv ')[1:])
cmd = 'mv -v -- "' + path + '" ./'
g.es(c.p.h)
g.es(execute(cmd))
</t>
<t tx="caminhante.20211012181130.1">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

path = ''.join(c.p.h.split('@cp ')[1:])
cmd = 'cp -v -- "' + path + '" ./'
g.es(c.p.h)
g.es(execute(cmd))
</t>
<t tx="caminhante.20211024192337.2">@tabwidth -2
@nocolor</t>
<t tx="caminhante.20211024192713.1"></t>
<t tx="caminhante.20211024192714.6">@path tests</t>
<t tx="caminhante.20211024192714.7">@path src</t>
<t tx="caminhante.20211024192714.8">@path .git</t>
<t tx="caminhante.20211024194140.1"></t>
<t tx="caminhante.20211024194140.2"></t>
<t tx="caminhante.20211024194321.1">@path vendor</t>
<t tx="caminhante.20211024200631.1">@path O</t>
<t tx="caminhante.20211024200632.2">@first &lt;?php
namespace O;
@others

class VariableType {
  /** @var bool */
  public $isArray = FALSE;
  /** @var string */
  public $key = "void";
  /** @var string */
  public $value = "void";

  public function __construct ($isArray = FALSE, $key = "void", $value = "void") {
    $this-&gt;isArray = $isArray;
    $this-&gt;key = $key;
    $this-&gt;value = $value;
  }
}

/**
 * @param $p string
 * @return \O\StringClass
 */
function s ($p) {
  if ($p instanceof StringClass) {
    return $p;
  } else {
    return new StringClass($p);
  }
}
</t>
<t tx="caminhante.20220725214947.1">// verify that output and string handling occurs as UTF-8
if (!extension_loaded("mbstring")) {
  throw new \Exception("enable the mbstring extension in php.ini");
} else if (headers_sent()) {
  throw new \Exception("headers already sent, load O.php at the top of the page");
} else {
  ini_set("default_charset", "UTF-8");
  mb_internal_encoding("UTF-8");
};
</t>
<t tx="caminhante.20220725215630.1">/**
 * Supporting class for the s() function
 */
class StringClass implements \IteratorAggregate, \ArrayAccess {
private $s;
@others
  function __construct ($s) {
    $this-&gt;s = $s;
  }

  function __toString () {
    return strval($this-&gt;s);
  }

// PHP style API

  /**
   * Find the position of the first occurrence of a substring in a string
   * @param string $needle The string to search
   * @param int $offset The position to start searching
   * @return int
   */
  function pos ($needle, $offset = 0) {
    return mb_strpos($this-&gt;s, $needle, $offset);
  }

  /**
   * Find the position of the first occurrence of a case-insensitive substring in a string
   * @param string $needle The string to search
   * @param int $offset The position to start searching
   * @return int
   */
  function ipos ($needle, $offset = 0) {
    return mb_stripos($this-&gt;s, $needle, $offset);
  }

  /**
   * Find the position of the last occurrence of a substring in a string
   * @param string $needle The string to search
   * @param int $offset The position to start searching
   * @return int
   */
  function rpos ($needle, $offset = 0) {
    return mb_strrpos($this-&gt;s, $needle, $offset);
  }

  /**
   * Find the position of the last occurrence of a case-insensitive substring in a string
   * @param string $needle The string to search
   * @param int $offset The position to start searching
   * @return int
   */
  function ripos ($needle, $offset = 0) {
    return mb_strripos($this-&gt;s, $needle, $offset);
  }

  /**
   * Split a string by string
   * @param string $delimiter The boundary string
   * @param int $limit If limit is set and positive, the returned array will contain
   * a maximum of limit elements with the last element containing the rest of string.
   * @return array|ArrayClass
   */
  function explode ($delimiter, $limit = 0xFFFFFF) {
    // split in utf-8 characters
    if ($delimiter == "") {
      $l = min($this-&gt;len(), $limit);
      $r = array();
      for ($i = 0; $i &lt; $l; $i++) {
        $r[] = $this-&gt;substr($i, 1);
      };
      return $r;
    } else {
      return explode($delimiter, $this-&gt;s, $limit);
    }
  }

  /**
   * Strip whitespace (or other characters) from the beginning and end of a string
   * @param string $charlist Characters to strip
   * @return string|StringClass
   */
  function trim ($charlist = " \t\n\r\0\x0B") {
    return trim($this-&gt;s, $charlist);
  }

  /**
   * Strip whitespace (or other characters) from the beginning of a string
   * @param string $charlist Characters to strip
   * @return string|StringClass
   */
  function ltrim ($charlist = " \t\n\r\0\x0B") {
    return ltrim($this-&gt;s, $charlist);
  }

  /**
   * Strip whitespace (or other characters) from the end of a string
   * @param string $charlist Characters to strip
   * @return string|StringClass
   */
  function rtrim ($charlist = " \t\n\r\0\x0B") {
    return rtrim($this-&gt;s, $charlist);
  }

  /**
   * Pad a string to a certain length with another string
   * @param int $padLength Length in characters to pad to
   * @param string $padString String to pad with
   * @param int $padType STR_PAD_LEFT, STR_PAD_RIGHT (default) or STR_PAD_BOTH
   * @return string|StringClass
   */
  function pad ($padLength, $padString = " ", $padType = STR_PAD_RIGHT) {
    // padLength == byte length, so calculate it correctly
    $padLength += (strlen($this-&gt;s) - $this-&gt;len());
    $padStringByteToCharRatio = strlen($padString) / mb_strlen($padString);
    if ($padStringByteToCharRatio &gt; 1) {
      $charsToAdd = ($padLength - strlen($this-&gt;s));
      $padLength -= $charsToAdd;
      $padLength += ceil($charsToAdd * $padStringByteToCharRatio);
    };
    return str_pad($this-&gt;s, $padLength, $padString, $padType);
  }

  /**
   * Get the string length in characters
   * @return int
   */
  function len () {
    return mb_strlen($this-&gt;s);
  }

  /**
   * Make a string lowercase
   * @return string|StringClass
   */
  function tolower () {
    return mb_strtolower($this-&gt;s);
  }

  /**
   * Make a string uppercase
   * @return string|StringClass
   */
  function toupper () {
    return mb_strtoupper($this-&gt;s);
  }

  /**
   * Return part of a string
   * @param int $start If negative, counts from the end of the string
   * @param int $length
   * @return string|StringClass
   */
  function substr ($start = 0, $length = 0xFFFFFFF) {
    return mb_substr($this-&gt;s, $start, $length);
  }

  /**
   * Replace all occurrences of the search string with the replacement string
   * @param string $search The value being searched for
   * @param string $replace The replacement value
   * @param int $count If set, the number of replacements performed
   * @return string|StringClass
   */
  function replace ($search, $replace, &amp;$count = NULL) {
    return str_replace($search, $replace, $this-&gt;s, $count);
  }

  /**
   * Replace all occurrences of the search string (case-insensitive) with the replacement string
   * @param string $search The value being searched for
   * @param string $replace The replacement value
   * @param int $count If set, the number of replacements performed
   * @return string|StringClass
   */
  function ireplace ($search, $replace, &amp;$count = NULL) {
    return str_ireplace($search, $replace, $this-&gt;s, $count);
  }

  /**
   * Perform a regular expression match
   * @param string $pattern The pattern to search for
   * @param array $matches If provided it is filled with the results of the search
   * $matches[0] will contain the text that matched the full pattern,
   * $matches[1] will have the text that matched the first captured parenthesized subpattern, and so on.
   * @param int $flags If PREG_OFFSET_CAPTURE for every occurring match the appendant string offset will also be returned.
   * Note that this changes the value of matches into an array where every element is an array consisting of the matched string at offset 0 and its string offset into subject at offset 1.
   * @param int $offset Alternate start of the search (in characters)
   * @return int
   */
  function preg_match ($pattern, &amp;$matches = NULL, $flags = 0, $offset = 0) {
    if (!is_array($matches)) $matches = array();
    // convert offset from characters to bytes
    if ($offset) $offset = strlen($this-&gt;substr(0, $offset));
    $result = preg_match($pattern, $this-&gt;s, $matches, $flags, $offset);
    if ($flags &amp; PREG_OFFSET_CAPTURE) {
      foreach ($matches as &amp;$match) {
        // convert offset in bytes into offset in code points
        $match[1] = mb_strlen(substr($this-&gt;s, 0, $match[1]));
      }
    };
    return $result;
  }

  /**
   * Searches subject for all matches to the regular expression given in pattern and puts them in matches in the order specified by flags.
   * @param string $pattern The pattern to search for
   * @param array $matches If provided it is filled with the results of the search
   * @param int $flags {@see http://php.net/manual/en/function.preg-match-all.php}
   * @param int $offset Alternate start of the search (in characters)
   * @return int
   */
  function preg_match_all ($pattern, &amp;$matches = NULL, $flags = PREG_PATTERN_ORDER, $offset = 0) {
    if (!is_array($matches)) $matches = array();
    // convert offset from characters to bytes
    if ($offset) $offset = strlen($this-&gt;substr(0, $offset));
    $result = preg_match_all($pattern, $this-&gt;s, $matches, $flags, $offset);
    if ($flags &amp; PREG_OFFSET_CAPTURE) {
      foreach ($matches as &amp;$group) {
        foreach ($group as &amp;$match) {
          // convert offset in bytes into offset in code points
          $match[1] = mb_strlen(substr($this-&gt;s, 0, $match[1]));
        };
      };
    };
    return $result;
  }

  /**
   * Perform a regular expression search and replace
   * @param string|array $pattern The pattern(s) to search for
   * @param string|array $replacement The string(s) to replace with
   * Each element from $pattern is replaced with its counterpart from $replacement
   * @param int $limit The maximal number of replacements
   * @param int $count If specified it is filled with the number of replacements done
   * @return string|StringClass
   */
  function preg_replace ($pattern , $replacement , $limit = -1, &amp;$count = NULL) {
    return preg_replace($pattern, $replacement, $this-&gt;s, $limit, $count);
  }

  /**
   * Checks if a value exists in an array
   * @param array|ArrayClass $haystack
   * @return bool
   */
  function in_array ($haystack) {
    if (!is_array($haystack) &amp;&amp; ($haystack instanceof ArrayClass)) {
      $haystack = $haystack-&gt;raw();
    }
    return in_array($this-&gt;s, $haystack);
  }

// JavaScript-style API

  /**
   * Returns the specified character from a string.
   * @param int $index
   * @return string|StringClass
   */
  function charAt ($index) {
    return $this-&gt;substr($index, 1);
  }

  /**
   * Returns the index of the first occurrence of the specified value,
   * starting the search at fromIndex. Returns -1 if the value is not found.
   * @param string $search
   * @param int $start
   * @return int
   */
  function indexOf ($search, $start = 0) {
    $pos = s($this-&gt;substr($start))-&gt;pos($search);
    return ($pos === FALSE) ? -1 : $pos+$start;
  }

  /**
   * Returns the index of the last occurrence of the specified value,
   * starting the search at fromIndex. Returns -1 if the value is not found.
   * @param string $search
   * @param int $start
   * @return int
   */
  function lastIndexOf ($search, $start = 0) {
    $pos = s($this-&gt;substr(0, $start))-&gt;rpos($search);
    return ($pos === FALSE) ? -1 : $pos;
  }

  /**
   * Retrieves the matches when matching a string against a regular expression.
   * @param string $regexp
   * @return array|ArrayClass|null
   */
  function match ($regexp) {
    $matches = array();
    if ($this-&gt;preg_match($regexp, $matches)) {
      return $matches;
    };
    return NULL;
  }

  // replace() already implemented for PHP syntax

  /**
   * Splits the string into an array of strings
   * @param string $separator
   * @param int $limit
   * @return array|ArrayClass
   */
  function split ($separator = NULL, $limit = 0xFFFFFF) {
    if ($separator === NULL) return array($this-&gt;s);
    return $this-&gt;explode($separator, $limit);
  }

  // substr() already implemented for PHP syntax

  /**
   * Returns a subset of a string between one index and another,
   * or through the end of the string.
   * @param int $start
   * @param int $end
   * @return string|StringClass
   */
  function substring ($start, $end = NULL) {
    return $this-&gt;substr($start, ($end !== NULL) ? $end-$start : 0xFFFFFFF);
  }

  /**
   * Convert to lowercase
   * @return string|StringClass
   */
  function toLowerCase () {
    return $this-&gt;tolower();
  }

  /**
   * Convert to uppercase
   * @return string|StringClass
   */
  function toUpperCase () {
    return $this-&gt;toupper();
  }

  // trim() already implemented for PHP syntax

  /**
   * Removes whitespace from the left end of a string
   * @return string|StringClass
   */
  function trimLeft () {
    return $this-&gt;ltrim();
  }

  /**
   * Removes whitespace from the right end of a string
   * @return string|StringClass
   */
  function trimRight () {
    return $this-&gt;rtrim();
  }

  /**
   * Return the internal raw string value
   * @return string|StringClass
   */
  function valueOf () {
    return $this-&gt;s;
  }

// encoder functions

  /**
   * Securely encode the string for the html element context
   * {@see https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet}
   * @return string|StringClass
   */
  function html () {
    $s = htmlspecialchars($this-&gt;s, ENT_QUOTES, "UTF-8");
    $s = s($s)-&gt;replace("/", "&amp;#x2F;");
    $s = s($s)-&gt;replace("&amp;apos;", "&amp;#039;");
    return $s;
  }

  /**
   * Securely encode the string for the script element context
   * {@see https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet}
   * @return string|StringClass
   */
  function script () {
    return json_encode($this-&gt;s, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  /**
   * Securely encode the string for the JSON context
   * {@see https://www.owasp.org/index.php/Abridged_XSS_Prevention_Cheat_Sheet}
   * @return string|StringClass
   */
  function json () {
    return $this-&gt;script();
  }

// IteratorAggregate

  /**
   * @return \ArrayIterator|\Traversable
   */
  function getIterator () {
    $o = new \ArrayObject($this-&gt;explode(""));
    return $o-&gt;getIterator();
  }

// ArrayAccess

  function offsetExists ($offset) {
    return $offset &lt; $this-&gt;len();
  }

  function offsetGet ($offset) {
    return $this-&gt;substr($offset, 1);
  }

  function offsetSet ($offset, $value) {
    $char = s($value)-&gt;substr(0, 1);
    $this-&gt;s = $this-&gt;substr(0, $offset) . $char . $this-&gt;substr($offset + 1);
  }

  function offsetUnset ($offset) {
    $this-&gt;s = $this-&gt;substr(0, $offset);
  }

// other methods

  /**
   * parse type string (phplint / phpdoc syntax)
   * {@see http://www.icosaedro.it/phplint/phpdoc.html#types}
   * @return \O\VariableType
   */
  function parse_type () {
    $type = $this-&gt;s;
    $matches = array();
    $isArray = FALSE;
    $keyType = NULL;
    // array[keytype]type
    if (s($type)-&gt;preg_match("/array(?:\\[([\S]*)\\]([\S]*))?/", $matches)) {
      $isArray = TRUE;
      $keyType = $matches[1];
      $type = $matches[2];
      // type[]
    } else if (s($type)-&gt;preg_match("/([^\\[]+)\\[\\]/", $matches)) {
      $isArray = TRUE;
      $keyType = NULL;
      $type = $matches[1];
    } else if ($type == "array") {
      $isArray = TRUE;
      $keyType = NULL;
      $type = "mixed";
    };
    $validTypes = array(
      "void",
      "bool", "boolean",
      "int", "integer", "float", "double",
      "string", "resource", "object", "mixed");
    if (!s($keyType)-&gt;in_array($validTypes)) {
      if (empty($keyType) || !class_exists($keyType)) {
        $keyType = NULL;
      };
    };
    if (!s($type)-&gt;in_array($validTypes)) {
      if (empty($type) || !class_exists($type)) {
        $type = "mixed";
      };
    };
    return new VariableType($isArray, $keyType, $type);
  }

  /**
   * Set this string object to the empty string
   * @return string|StringClass
   */
  function clear () {
    return $this-&gt;s = "";
  }

  /**
   * Return the internal primitive string value
   * @return string
   */
  function raw () {
    return $this-&gt;s;
  }

}
</t>
</tnodes>
</leo_file>
