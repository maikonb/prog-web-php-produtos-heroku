# Exemplo de aplicação PHP para a disciplina de Prog. Web

## Demonstração

[Acesse a demonstração aqui.](http://guarded-hollows-90344.herokuapp.com/)

## Descrição

Essa aplicação contém todos os recursos aprendidos até agora na disciplina integrados. A idéia aqui é demonstrar como organizar uma aplicação utilizando a orientação a objetos com acesso a banco de dados SQL. 

## Recursos

- Linguagens: PHP, HTML e SQL
- Banco de dados: MySQL
- Framework CSS: Bootstrap
- Frameworks Backend: nenhum
- Deploy: Heroku

## Diagrama Modelo Entidade Relacionamento do exemplo

![Modelo Entidade Relacionamento](/images/modelo-cadastro-produtos.png)

## Passos para deploy no Heroku

O [Heroku](https://www.heroku.com/) consiste uma plataforma para realizar deploys de aplicações e possui muitos recursos para automatizar o processo de deploy, maximizar o desempenho das aplicações, além de ferramentas de monitoramento e gerência. Ele também possibilita que seu serviço possa ser utilizado gratuitamente, dependendo dos recursos que são utilizados.

Utilizaremos o Heroku para realizar o deploy dessa aplicação exemplo e ***não deve** ser cobrada nenhuma taxa, pois utilizaremos os recursos mínimos.

Para realizar o deploy da aplicação:

1. Clone este repositório em seu ambiente e **remova a pasta .git** (isso é muito importante).
1. Crie uma conta no Heroku. Adicione também um método de pagamento, esse passo é necessário para que você possa utilizar um addon para criar uma base de dados MySQL. No entanto, não será utilizado para cobrar nenhuma taxa, só é requisito para utilização do addon.
1. Instale o Heroku CLI em seu computador: [Tutorial](https://devcenter.heroku.com/articles/heroku-cli)
1. Abra seu terminal e entre na pasta do seu projeto clonado (com o diretório .git já removido)
1. Com o terminal aberto e já dentro da pasta do projeto, execute os passos a seguir.

- Faça o login no heroku utilizando o comando: 
```
heroku login
``` 

- Crie um repositório git e faça seu primeiro commit incluindo todos os arquivos (Obs.: Você precisa ter o git instalado em seu computador):
```
git init
git add .
git commit -m "Adicionando projeto."
```

- Crie um projeto heroku: 
```
heroku create
```

- Adicione o mysql em seu deploy (você precisa adicionar um método de pagamento para utilizar este addon, mesmo não sendo cobrado): 
```
heroku addons:create cleardb:ignite
```

- Certique-se de que o addon foi instalado corretamente:
```
heroku addons
```
A saída deve ser parecida com essa:
```
Add-on                               Plan    Price  State  
───────────────────────────────────  ──────  ─────  ───────
cleardb (cleardb-rectangular-71496)  ignite  free   created
 └─ as CLEARDB_DATABASE
```

- Realize um push de seu projeto para o respositório do heroku:
```
git push heroku master
```

- Execute os seguintes scripts que criarão as tabelas e cadastrarão seus primeiros registros.
```
heroku run 'php /app/migration/criar-tabelas.php'
heroku run 'php /app/migration/criar-registros.php'
```

- Utilize o comando a seguir para abrir a URL de seu projeto:
```
heroku open
```

***Importante:*** A cada nova modificação em seu código fonte: adicione o arquivo modificado ao repositório e realize novamente o push:
```
git add *
git commit -m "Adicionando modificacao ao projeto."
git push heroku master
```
