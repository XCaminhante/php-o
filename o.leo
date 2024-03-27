<?xml version="1.0" encoding="utf-8"?>
<!-- Created by Leo: https://leo-editor.github.io/leo-editor/leo_toc.html -->
<leo_file xmlns:leo="http://leo-editor.github.io/leo-editor/namespaces/leo-python-editor/1.1" >
<leo_header file_format="2"/>
<globals/>
<preferences/>
<find_panel_settings/>
<vnodes>
<v t="caminhante.20240321163358.1"><vh>@settings</vh>
<v t="caminhante.20240321163358.2"><vh>@command terminal-here @key=Alt-T</vh></v>
<v t="caminhante.20240321163358.3"><vh>@data abbreviations</vh></v>
<v t="caminhante.20240321163358.4"><vh>@outline-data tree-abbreviations</vh></v>
<v t="caminhante.20240321163358.5"><vh>nodeActions</vh>
<v t="caminhante.20240321163358.6"><vh>@bin *</vh></v>
<v t="caminhante.20240321163358.7"><vh>@cmd *</vh></v>
<v t="caminhante.20240321163358.8"><vh>@cp *</vh></v>
<v t="caminhante.20240321163358.9"><vh>@files Makefile</vh></v>
<v t="caminhante.20240321163358.10"><vh>@mkdir *</vh></v>
<v t="caminhante.20240321163358.11"><vh>@mv *</vh></v>
<v t="caminhante.20240321163358.12"><vh>@rm *</vh></v>
<v t="caminhante.20240321163358.13"><vh>@rmdir /*/</vh></v>
<v t="caminhante.20240321163358.14"><vh>@run|@run .* [X]</vh></v>
<v t="caminhante.20240321163358.15"><vh>\@edit * [X]</vh></v>
<v t="caminhante.20240321163358.16"><vh>\@file * [X]</vh></v>
<v t="caminhante.20240321163358.17"><vh>/*/</vh></v>
<v t="caminhante.20240321163358.18"><vh>\@path * [X]</vh></v>
<v t="caminhante.20240321163358.19"><vh>@*</vh></v>
<v t="caminhante.20240321163358.20"><vh>*</vh></v>
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
<v t="caminhante.20240327153006.1"><vh>@file FileClass.php</vh></v>
<v t="caminhante.20211024200632.7"><vh>@file O.php</vh></v>
<v t="caminhante.20211024200632.6"><vh>@file ObjectClass.php</vh></v>
<v t="caminhante.20211024200632.5"><vh>@file PDO.php</vh></v>
<v t="caminhante.20211024200632.4"><vh>@file ReflectionClass.php</vh></v>
<v t="caminhante.20211024200632.3"><vh>@file Session.php</vh></v>
<v t="caminhante.20211024200632.2"><vh>@file StringClass.php</vh></v>
<v t="caminhante.20211024200632.1"><vh>@file Validator.php</vh></v>
</v>
</v>
<v t="caminhante.20211024192714.6"><vh>/tests/</vh>
<v t="caminhante.20230706212234.10"><vh>@file AllTests.php</vh></v>
<v t="caminhante.20230706212234.9"><vh>@file OArrayTest.php</vh></v>
<v t="caminhante.20230706212234.8"><vh>@file OChainableTest.php</vh></v>
<v t="caminhante.20230706212234.7"><vh>@file ODateTimeTest.php</vh></v>
<v t="caminhante.20230706212234.6"><vh>@file OObjectTest.php</vh></v>
<v t="caminhante.20230706212234.5"><vh>@file OPDOMySQLTest.php</vh></v>
<v t="caminhante.20230706212234.4"><vh>@file OPDOTest.php</vh></v>
<v t="caminhante.20230706212234.3"><vh>@file OReflectionTest.php</vh></v>
<v t="caminhante.20230706212234.2"><vh>@file OStringTest.php</vh></v>
<v t="caminhante.20230706212234.1"><vh>@file OValidatorTest.php</vh></v>
</v>
<v t="caminhante.20211024192714.3"><vh>@auto README.md</vh></v>
<v t="caminhante.20211024194133.1"><vh>@edit .gitignore</vh></v>
<v t="caminhante.20211024192714.2"><vh>@edit composer.json</vh></v>
<v t="caminhante.20211024192714.5"><vh>@edit LICENSE</vh></v>
<v t="caminhante.20211024192714.4"><vh>@file O.php</vh></v>
<v t="caminhante.20211024194140.1"><vh>o.leo</vh></v>
</v>
</v>
</vnodes>
<tnodes>
<t tx="caminhante.20211024192337.2">@tabwidth -2
@language text</t>
<t tx="caminhante.20211024192713.1"></t>
<t tx="caminhante.20211024192714.6">@path tests</t>
<t tx="caminhante.20211024192714.7">@path src</t>
<t tx="caminhante.20211024192714.8">@path .git</t>
<t tx="caminhante.20211024194140.1"></t>
<t tx="caminhante.20211024200631.1">@path O</t>
<t tx="caminhante.20240321163358.1">@tabwidth -2
</t>
<t tx="caminhante.20240321163358.10">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

path = ''.join(c.p.h.split('@mkdir ')[1:])
cmd = "mkdir -p -- '" + path + "'"
g.es(c.p.h)
execute(cmd)
c.p.h = '/'+path+'/'
c.p.b = '@path ' + path
</t>
<t tx="caminhante.20240321163358.11">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

if 'file://' in c.p.h:
  path = ''.join(c.p.h.split('@mv file://')[1:])
else:
  path = ''.join(c.p.h.split('@mv ')[1:])

cmd = "mv -v -- '" + path + "' ./"
g.es(c.p.h)
g.es(execute(cmd))
</t>
<t tx="caminhante.20240321163358.12">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

filename = ''.join(c.p.h.split('@rm ')[1:])
cmd = 'rm -vf -- "' + filename + '"'
g.es(c.p.h)
g.es(execute(cmd))
c.p.deleteAllChildren()
c.redraw(c.p)
</t>
<t tx="caminhante.20240321163358.13">import subprocess
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
c.p.deleteAllChildren()
c.redraw(c.p)
</t>
<t tx="caminhante.20240321163358.14">@language python
import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)

w = c.frame.body.wrapper
s1,s2 = w.getSelectionRange()

if s1 == s2:
    code = c.p.b
else:
    linebr = c.p.b.find('\n',s2)
    if linebr == -1: linebr = len(c.p.b)
    code = c.p.b[s1:s2]

g.es(c.p.h)

command = "cat &lt;&lt;'EOFEOFEOFEOFEOFEOF' | bash\ncd '"+path+"';\n"+code+'\nEOFEOFEOFEOFEOFEOF'

if c.isChanged(): c.save()

cpc = c.p.copy()
novoNo = cpc.insertAsLastChild()
novoNo.h = c.p.h + ' ['+code[0:6]+'...]'
novoNo.b = execute(command)

c.save()
w.setSelectionRange(s1,s2)
c.redraw(c.p)
</t>
<t tx="caminhante.20240321163358.15">path = ''.join(c.p.h.split('@edit ')[1:])
c.p.h = path
c.p.b = ''
</t>
<t tx="caminhante.20240321163358.16">path = ''.join(c.p.h.split('@file ')[1:])
c.p.h = path
c.p.b = ''
c.p.deleteAllChildren()
c.redraw(c.p)
</t>
<t tx="caminhante.20240321163358.17">c.p.deleteAllChildren()
c.p.setDirty()
c.redraw(c.p)
</t>
<t tx="caminhante.20240321163358.18">c.p.deleteAllChildren()
c.p.setDirty()
c.redraw(c.p)
</t>
<t tx="caminhante.20240321163358.19"></t>
<t tx="caminhante.20240321163358.2">@language python
import subprocess

def execute (cmd):
    return subprocess.Popen(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

if c.isChanged(): c.save()
path = c.getNodePath(c.p)

execute('x-terminal-emulator --working-directory="'+path+'"')
</t>
<t tx="caminhante.20240321163358.20">path = c.getNodePath(c.p)

import re

def fileHasPattern (fname, pattern):
  fp = open(path +'/'+ fname)
  for i, line in enumerate(fp):
    if i == 50:
      break
    if re.search(pattern, line):
      return True
  return False

def loadFileNode (ftype,fname):
  at = c.atFileCommands
  c.p.deleteAllChildren()
  c.p.h = "@"+ftype+" "+fname
  c.recreateGnxDict()
  at.readFileAtPosition(c.p)

if fileHasPattern(c.p.h, r"leo-ver=5-thin"):
  loadFileNode('file', c.p.h)
elif fileHasPattern(c.p.h, r"&lt;leo_file xmlns:leo="):
  g.openWithFileName(path +'/'+ c.p.h)
else:
  loadFileNode('edit', c.p.h)

c.p.setDirty()
c.redraw(c.p)
c.p.contract()
</t>
<t tx="caminhante.20240321163358.3"></t>
<t tx="caminhante.20240321163358.4"></t>
<t tx="caminhante.20240321163358.5">@language python
</t>
<t tx="caminhante.20240321163358.6">import subprocess

def execute (cmd):
  return subprocess.run(
    cmd,shell=True,
    universal_newlines=True,
    stderr=subprocess.STDOUT,
    stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

command = ''.join(c.p.h.split('@bin ')[1:])
command = "xxd -- '"+command+"'"

g.es(c.p.h)
c.p.b = execute(command)

c.save()
</t>
<t tx="caminhante.20240321163358.7">import subprocess

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
<t tx="caminhante.20240321163358.8">import subprocess

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

path = c.getNodePath(c.p)
g.os.chdir(path)

if 'file://' in c.p.h:
  path = ''.join(c.p.h.split('@cp file://')[1:])
else:
  path = ''.join(c.p.h.split('@cp ')[1:])

cmd = "cp -v -- '" + path + "' ./"
g.es(c.p.h)
g.es(execute(cmd))
</t>
<t tx="caminhante.20240321163358.9">@language python
import subprocess
import re

def execute (cmd):
    return subprocess.run(cmd,shell=True,universal_newlines=True,stderr=subprocess.STDOUT,stdout=subprocess.PIPE).stdout

if c.isChanged(): c.save()

path = c.getNodePath(c.p)
g.os.chdir(path)

cpc = c.p.copy()
novoNo = cpc.insertAfter()
novoNo.h = 'make return'
novoNo.b = execute('make')
c.redraw(c.p)
</t>
</tnodes>
</leo_file>
