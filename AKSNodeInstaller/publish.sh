# 构建和推送到 DockerHub
docker build -t snowpeak/node-installer:1.0 .
docker push snowpeak/node-installer:1.0
# 构建和推送到 Azure Container Registry
az acr build --resource-group demo --registry snowpeak --image node-installer:1.0 .
# 执行 kubernetes 配置
kubectl apply -f ./k8s
