```
heroku login
git add .
git commit -m "Adicionando projeto."
heroku create
heroku addons
git push heroku master
heroku addons:create cleardb:ignite
heroku config | grep CLEARDB_DATABASE_URL
heroku logs --tail
heroku open
git add *
git commit -m "alterando conexao com bd"
heroku run 'php /app/migration/criar-tabelas.php'
heroku run 'php /app/migration/criar-registros.php'
```
