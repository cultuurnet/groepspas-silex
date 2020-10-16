// This script is intended to be called from the repo root.
// Prerequisites:
// Groovy installed(latest versio is ok)
// Node.js version 6.11.1 installed
// Bundler installed
// Run: bundler

//This function runs a bash command, waits for it to finish, and outputs the results.
def runCommand = { command -> 
  println command
  def proc = command.execute()
  proc.in.eachLine { line -> println line }
  proc.out.close()
  proc.waitFor()

  if (proc.exitValue()) {
     println "[ERROR] ${proc.getErrorStream()}"
  }
}


println "Creating a debian package from the binaries."

def currentDir = new File( "." ).getCanonicalPath()
println "Current dir:" + currentDir

runCommand "composer --version" // For logging purposes.
runCommand "phing -version"  // For logging purposes.
            
//runCommand "phing composer" // Run target composer in build.xml

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


//pipeline.sh(script: 'mkdir pkg')
//pipeline.sh(script: "bundle exec fpm -v ${pipelinVersion} ${fpmArgs}")
