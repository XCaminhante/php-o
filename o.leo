<?xml version="1.0" encoding="utf-8"?>
<!-- Created by Leo: https://leo-editor.github.io/leo-editor/leo_toc.html -->
<leo_file xmlns:leo="https://leo-editor.github.io/leo-editor/namespaces/leo-python-editor/1.1" >
<leo_header file_format="2"/>
<globals/>
<preferences/>
<find_panel_settings/>
<vnodes>
<v t="caminhante.20260509212457.1"><vh>@settings</vh>
<v t="caminhante.20251129202339.1"><vh>nodeActions</vh>
<v t="caminhante.20251129203431.1"><vh>@rm /*/</vh></v>
<v t="caminhante.20251129202900.1"><vh>@rm *</vh></v>
<v t="caminhante.20251129203456.1"><vh>@mkdir *</vh></v>
<v t="caminhante.20251129204106.1"><vh>@run *</vh></v>
<v t="caminhante.20251129213245.1"><vh>@cmd *</vh></v>
<v t="caminhante.20251129202344.1"><vh>@files *</vh></v>
<v t="caminhante.20231002175916.1"><vh>@path *</vh></v>
<v t="caminhante.20230623181912.1"><vh>/*/</vh></v>
<v t="caminhante.20240307132645.1"><vh>@*</vh></v>
<v t="caminhante.20260410143003.1"><vh>*</vh></v>
</v>
</v>
<v t="caminhante.20211024192337.2"><vh>PHP-O</vh>
<v t="caminhante.20211024192713.1"><vh>@path .</vh>
<v t="caminhante.20260509212528.3"><vh>.project</vh></v>
<v t="caminhante.20211024192714.8"><vh>/.git/</vh></v>
<v t="caminhante.20260509212528.2"><vh>/.settings/</vh></v>
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
<v t="caminhante.20260509212528.1"><vh>o.leo.bak</vh></v>
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
<t tx="caminhante.20230623181912.1">c.p.deleteAllChildren()
c.p.setDirty()
c.redraw(c.p)
</t>
<t tx="caminhante.20231002175916.1">c.p.deleteAllChildren()
c.p.setDirty()
c.redraw(c.p)
</t>
<t tx="caminhante.20240307132645.1"></t>
<t tx="caminhante.20251129202339.1"></t>
<t tx="caminhante.20251129202344.1">head = c.p.h.split(" ",1)
c.p.h = head[1]
c.p.b = ""
g.es(head[1]+" unloaded")
c.p.deleteAllChildren()
#c.redraw_later()
c.p.setDirty()
c.redraw(c.p)
</t>
<t tx="caminhante.20251129202900.1">import subprocess
path = c.fullPath(c.p)
head = c.p.h.split(" ",1)
proc = subprocess.run(["rm", "-fv", path+'/'+head[1]], capture_output=True)
c.p.b = proc.stdout
c.p.deleteAllChildren()
c.redraw_later()
</t>
<t tx="caminhante.20251129203431.1">import subprocess
path = c.fullPath(c.p)
proc = subprocess.run(["rm", "-fvr", path], capture_output=True)
c.p.b = proc.stdout
c.p.deleteAllChildren()
c.redraw_later()
</t>
<t tx="caminhante.20251129203456.1">import subprocess
path = c.fullPath(c.p)
head = c.p.h.split(" ",1)
proc = subprocess.run(["mkdir", "-p", path+'/'+head[1]])
c.p.h = f"/{head[1]}/"
c.p.b = f"@path {head[1]}"
</t>
<t tx="caminhante.20251129204106.1">import subprocess
path = c.fullPath(c.p)
proc = subprocess.run(["bash"], capture_output=True, cwd=path, text=True, input=c.p.b)
child = c.p.insertAsFirstChild()
child.h = c.p.h
child.b = proc.stdout
if len(proc.stderr) &gt; 0:
    g.es(proc.stderr)
c.redraw_later()
</t>
<t tx="caminhante.20251129213245.1">import subprocess
path = c.fullPath(c.p)
head = c.p.h.split(" ",1)
proc = subprocess.run(["bash"], capture_output=True, cwd=path, text=True, input=head[1])
c.p.b += proc.stdout
if len(proc.stderr) &gt; 0:
    g.es(proc.stderr)
</t>
<t tx="caminhante.20260410143003.1">import re
path = c.fullPath(c.p)

def fileHasPattern (fname, pattern):
  fp = open(path+"/"+fname)
  for i, line in enumerate(fp):
    if i == 10:
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
  g.openWithFileName(c.p.h)
else:
  loadFileNode('edit', c.p.h)

c.p.setDirty()
c.redraw(c.p)
c.p.contract()
</t>
<t tx="caminhante.20260509212457.1"></t>
<t tx="caminhante.20260509212528.1"></t>
<t tx="caminhante.20260509212528.2">@path .settings</t>
<t tx="caminhante.20260509212528.3"></t>
</tnodes>
</leo_file>
