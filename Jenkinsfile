pipeline  {
 
  agent agent1
  
  stages {
   
    stage('Checkout') {
     
      step {
      scm checkout
      }
      
    }
    
   stage("Make tar.gz") {
    
    step {
     sh 'tar -czf custosales-0.0.10.tgz *'
    }
    
   }
   
    stage('Upload to Nexus') {
     
      step {
       nexusArtifactUploader artifacts: [[artifactId: 'custosales-0.0.10.tgz', classifier: '', file: 'custosales-0.0.10.tgz', type: 'tgz']], credentialsId: 'c9b3d9ca-d42d-4688-9f04-5d63007b1332', groupId: 'custosales', nexusUrl: 'noderia.com:8081', nexusVersion: 'nexus3', protocol: 'http', repository: 'CustSales-dev', version: '0.0.10'
     }
      
    }
    
   
    
  }
  
  
}  
