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
<v t="caminhante.20211024200632.10"><vh>@edit ArrayClass.php</vh></v>
<v t="caminhante.20211024200632.9"><vh>@edit ChainableClass.php</vh></v>
<v t="caminhante.20211024200632.8"><vh>@edit DateTime.php</vh></v>
<v t="caminhante.20211024200632.5"><vh>@edit PDO.php</vh></v>
<v t="caminhante.20211024200632.4"><vh>@edit ReflectionClass.php</vh></v>
<v t="caminhante.20211024200632.3"><vh>@edit Session.php</vh></v>
<v t="caminhante.20211024200632.2"><vh>@edit StringClass.php</vh></v>
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
</tnodes>
</leo_file>
