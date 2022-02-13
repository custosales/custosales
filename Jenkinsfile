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
         sh 'npm install'
      }
    }

    stage('Make tar.gz') {
      steps {
        sh "rm *.tgz || true"
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
    
    stage('Message Mattermost & mail Terje') {
      steps {
        mattermostSend channel: 'custosalessupport@custosales,back-end,town-square', endpoint: 'http://mattermost.custosales.com:8065/hooks/7htswxrystygiyaq17mf1cdx3e', message: "### Bare Hyggelig!  From CustoSales Dev Team \n  - Jenkins says:  Job Name: ${env.JOB_NAME}   Build Number:  ${env.BUILD_NUMBER}  :tada:", text: '### New version on github.com and hub.docker.com  :white_check_mark:'
        emailext body: "Dette er en mail fra Jenkins pipeline\n Jenkins says:  Job Name: ${env.JOB_NAME}   \nBuild Number:  ${env.BUILD_NUMBER} gikk bra!", subject: 'CustoSales Build Success', to: 'terje@itfakultetet.no'
      }
    }
  }

  post {
    
    failure {
         emailext body: "Dette er en mail fra Jenkins pipeline\n Jenkins says:  Job Name: ${env.JOB_NAME}   \nBuild Number:  ${env.BUILD_NUMBER} mislyktes!", subject: 'CustoSales Build Failed', to: 'terje@itfakultetet.no'
    }
    always {
        archiveArtifacts artifacts: "custosales-0.0.${env.BUILD_NUMBER}.tgz", fingerprint: true
        sh "docker rmi $imagename:$BUILD_NUMBER || true"
        sh "docker rmi $imagename:latest || true"
        }
  }
}
