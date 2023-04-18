# Criando Api com php
    Challenge para gerenciamento de despesas com uso de Api
    gerenciar rotas

## Como usar:
    baixe e instale as dependencias com composer update
    para usar o servidor: digite no terminal php -S localhost:8000 -t public

### Rotas utilizadas 
     [GET]
     - /receitas para listas todas as receitas.
     - /receitas/{id} busca a receita pelo id.
     - /receitas/{ano}/{mes} lista todas as receitas do ano e mês.
     - /receitas/{ano}/{mes}/{dia} lista todas as receitas do dia.

     [POST]
     - /receitas para inserir uma receita.

     [PUT]
     - /receitas/{id} para editar uma receita.

     [DELETE]
     - /receitas/{id} para deletar uma receita.
###
     [GET]
     - /despesas para listas todas as despesas.
     - /despesas/{id} busca a despesa pelo id.
     - /despesas/{ano}/{mes} lista todas as despesas do ano e mês.
     - /despesas/{ano}/{mes}/{dia} lista todas as despesas do dia.

     [POST]
     - /despesas para inserir uma despesa.

     [PUT]
     - /despesas/{id} para editar uma despesa.

     [DELETE]
     - /despesas/{id} para deletar uma despesa.



