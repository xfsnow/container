FROM webdevops/php-nginx
# aws_credentials.txt will be created in buildspec.yaml during CodeBuild.
COPY aws_credentials.txt /home/application/.aws/credentials
COPY . /app
CMD ["/usr/bin/supervisord"]