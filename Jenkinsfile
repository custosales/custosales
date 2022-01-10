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
     
      nexusArtifactUploader artifacts: [[artifactId: 'CustoSales-dev', classifier: 'all', file: 'custosales-0.0.10.tgz', type: 'tgz']], 
       credentialsId: 'c9b3d9ca-d42d-4688-9f04-5d63007b1332', 
       groupId: 'CustoSales', 
       nexusUrl: 'noderia.com:8081', 
       nexusVersion: 'nexus3', 
       protocol: 'http', 
       repository: 'CustSales-dev', 
       version: '0.0.10'
      
     }
    }
   
    
  }
  
  
}  
