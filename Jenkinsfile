pipeline {
  environment {
    imagename = 'terjebh/custosales'
    registryCredential = 'dockerhub'
    dockerImage = ''
  }

  agent {
    label 'master'
  }

  stages {
    stage('npm install') {
      steps {
        configFileProvider([configFile(fileId: 'b4d70ee1-e2d9-407b-b6de-61fc3745ae73', targetLocation: '.env')]) {
        }
        sh 'npm install'
      }
    }

    stage('Make tar.gz') {
      steps {
        sh "rm custosales-0.0.${env.BUILD_NUMBER-1}.tgz"
        sh "tar -czf custosales-0.0.${env.BUILD_NUMBER}.tgz *"
      }
    }

    stage('Build docker image') {
      steps {
        script {
          dockerImage = docker.build imagename
        }
      }
    }

    stage('Deploy Docker Image to Dockerhub') {
      steps {
        script {
          docker.withRegistry( '', registryCredential ) {
            dockerImage.push("$BUILD_NUMBER")
            dockerImage.push('latest')
          }
        }
      }
    }
    stage('Remove Unused docker image') {
      steps {
        sh "docker rmi $imagename:$BUILD_NUMBER"
        sh "docker rmi $imagename:latest"
      }
    }

    stage('Message Mattermost') {
      steps {
        mattermostSend channel: 'custosalessupport@custosales,back-end,town-square', endpoint: 'http://mattermost.custosales.com:8065/hooks/7htswxrystygiyaq17mf1cdx3e', message: "### Bare Hyggelig!  From CustoSales Dev Team \n  - Jenkins says:  Job Name: ${env.JOB_NAME}   Build Number:  ${env.BUILD_NUMBER}  :tada:", text: '### New version on github.com and hub.docker.com  :white_check_mark:'
      }
    }
  }

  post {
        always {
        archiveArtifacts artifacts: 'custosales-0.0.1.tgz', fingerprint: true
        }
  }
}
