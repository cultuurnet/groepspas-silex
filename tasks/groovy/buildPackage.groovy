// This script is intended to be called from the repo root.
// Prerequisites:
// Groovy installed(latest versio is ok)
// Node.js version 6.11.1 installed
// Bundler installed
// Run: bundle install --deployment --no-color (this installs fpm among other things) 
import java.text.SimpleDateFormat

String version = ''
if(args.size() > 0){
   version = this.args[0]
}
else{
   println "No file name provided, using yyyyMMddHHmmss"
   def now = new Date()
   version = now.format("yyyyMMddHHmmss") 
}

//This function runs a bash command, waits for it to finish, and outputs the results.
def runCommand = { command ->
  //print command
  if(command instanceof List) {
     command.each { print "${it} " }
     println " "
  } else {
     println command
  }
    
  def sout = new StringBuilder(), serr = new StringBuilder()
  def proc = command.execute()
  proc.consumeProcessOutput(sout, serr)  
  //proc.in.eachLine { line -> println line }
  proc.out.close()
  proc.waitFor()
  println "$sout"

  if (proc.exitValue()) {
     println "[ERROR] ${proc.getErrorStream()}"
      println "${serr}"
     System.exit(proc.exitValue())
  }
}

println "Creating a debian package from the binaries."

def currentDir = new File( "." ).getCanonicalPath()
println "Current dir:" + currentDir

runCommand "composer --version" // For logging purposes.
runCommand "phing -version"  // For logging purposes.
            
runCommand "phing composer" // Run target composer in build.xml

//Create new file with content, 
def configFile = new File("config.yml")
configFile.createNewFile()
configFile.text = '''cors:
  origins:
    - http://localhost:9000/
    - http://localhost:9000
uitid:
  consumer:
    key:
    secret:
  base_url: https://acc.uitid.be/uitid/rest/
debug: false'''
println configFile.text

def dir = new File("pkg")
dir.mkdirs() //Make new directory

// build the fpm command
List command = ['bundle', 'exec', 'fpm', '-t', 'deb', '-n', 'groepspas-silex', '-v', "${version}", 
                '-s', 'dir', '-a', 'all', '-p', 'pkg', '-x', '\".git*\"', '-x', 'pkg', '-x', 'config.dist.yml',
                '--license', '\"Apache-2.0\"', '-m', 'Infra publiq <infra@publiq.be>',
                '--url', '''"https://www.publiq.be"''', '--vendor', 'publiq vzw',
                '--description', '\"Silex backend for Groepspas\"', '--prefix', '''/var/www/groepspas-api''',
                '--deb-user', 'www-data', '--deb-group', 'www-data',
                '-d', '''php5-cli | php5.6-cli | php7.0-cli | php7.1-cli''',
                '--config-files', '''/var/www/groepspas-api/config.yml''', '.']
                
runCommand command

return this
