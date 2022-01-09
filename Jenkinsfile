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
     
      nexusArtifactUploader artifacts: [[artifactId: '', classifier: '', file: 'custosales-0.0.10.tgz', type: 'tgz']], 
       credentialsId: '27c5f993-86c4-4494-bc35-932e51916616', 
       groupId: 'custosales', 
       nexusUrl: 'noderia.com:8081', 
       nexusVersion: 'nexus3', 
       protocol: 'http', 
       repository: 'CustSales-dev', 
       version: '0.0.10'
     
     }
    }
   
    
  }
  
  
}  
