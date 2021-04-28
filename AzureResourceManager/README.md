# 部署模板
```
az group create --name arm-vscode --location chinanorth2

az deployment group create --resource-group arm-vscode --template-file azuredeploy.json --debug

```

有报错时加 --debug 参数
```
az deployment group create --resource-group arm-vscode --template-file azuredeploy.json --debug
```
详细报错信息会在 HTTP 日志中返回，比如
```
msrest.http_logger : {"error":{"code":"InvalidTemplateDeployment","message":"The template deployment 'azuredeploy' is not valid according to the validation procedure. The tracking id is 'ebadd757-7c5a-4c72-9e17-79d7c6067bb8'. See inner errors for details.","details":[{"code":"PreflightValidationCheckFailed","message":"Preflight validation failed. Please refer to the details for the specific errors.","details":[{"code":"AccountNameInvalid","target":"arm_vscode","message":"arm_vscode is not a valid storage account name. Storage account name must be between 3 and 24 characters in length and use numbers and lower-case letters only."}]}]}}
```

可以看到真正的错误原因是 
```
arm_vscode is not a valid storage account name. Storage account name must be between 3 and 24 characters in length and use numbers and lower-case letters only.
```

其实只是 storage account 名称的值不符合规范。

稍等一会，创建成功后，可以列一下看看

```
az storage account show -n armvscode -g arm-vscode --output table
```

返回

```
AccessTier    CreationTime                      EnableHttpsTrafficOnly    Kind       Location     Name       PrimaryLocation    ProvisioningState    ResourceGroup    StatusOfPrimary
------------  --------------------------------  ------------------------  ---------  -----------  ---------  -----------------  -------------------  ---------------  -----------------
Hot           2021-04-28T09:28:13.010298+00:00  True                      StorageV2  chinanorth2  armvscode  chinanorth2        Succeeded            arm-vscode       available
```

最好把整个资源组删掉。