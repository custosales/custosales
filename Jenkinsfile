pipeline  {
 
   agent { label 'ubuntu' }
 
  stages {
   
   stage("Make tar.gz") {
    steps { 
    sh 'tar -czf custosales-0.0.10.tgz *'
    }
   }
   
    stage('Upload to Nexus') {
     steps {
     
           
      nexusArtifactUploader 
        nexusVersion: 'nexus3',
        protocol: 'http',
        nexusUrl: 'noderia.com:8081',
        groupId: 'custosales',
        version: '0.0.10',
        repository: 'CustSales-dev',
        credentialsId: 'c9b3d9ca-d42d-4688-9f04-5d63007b1332',
        artifacts: [
        [artifactId: 'custosales-dev',
         classifier: '',
         file: 'custosales-0.0.10.tgz',
         type: 'tgz']
        ]
        
     
     }
    }
   
    
  }
  
  
}  
