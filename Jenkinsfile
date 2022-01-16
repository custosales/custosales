pipeline {
   environment {
          imagename = 'terjebh/custosales'
          registryCredential = 'dockerhub'
          dockerImage = ''
        }

   agent {
     label "master"
   } 
   
  stages {
   
   stage("npm install") {
    steps { 
    sh 'npm install'
    }
   }
  
     
     
   stage("Make tar.gz") {
    steps { 
    sh 'tar -czf custosales-0.0.10.tgz *'
    }
   }

    stage('Build docker image') {
              steps{
                script {
                  dockerImage = docker.build imagename
                }
              }
           }

     stage('Deploy Docker Image to Dockerhub') {
              steps{
                script {
                  docker.withRegistry( '', registryCredential ) {
                    dockerImage.push("$BUILD_NUMBER")
                     dockerImage.push('latest')

                  }
                }
              }
            }
            stage('Remove Unused docker image') {
              steps{
                sh "docker rmi $imagename:$BUILD_NUMBER"
                 sh "docker rmi $imagename:latest"

              }
            }

          stage('Message Mattermost') {
               steps {
    
mattermostSend channel: 'terje@custosales,#back-end,town-square', endpoint: 'http://mattermost.custosales.com:8065/hooks/mrdop611a3ns3qadqciy6qywjo', message: 'New version in Github - Jenkins says:  Job Name: ${env.JOB_NAME}   Build Number:  ${env.BUILD_NUMBER}', text: 'Bare Hyggelig !   From CustoSales Dev Team'

               }
              }


          }

}
