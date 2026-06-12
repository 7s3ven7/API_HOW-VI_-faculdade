
# Como criar uma nova rota

1. Abra o arquivo api.php.
2. Adicione uma nova rota seguindo os exemplos existentes.
3. Crie uma classe Service para implementar a regra de negócio.
4. Caso precise acessar o banco, utilize um Repository.
5. Se a entidade possuir estrutura própria, crie uma classe em Entity.

# Estrutura do projeto

 - index.php → ponto de entrada da aplicação.
 - api.php → definição das rotas.
 - Entity/ → classes que representam os dados da aplicação.
 - Repository/ → responsável pelo acesso ao banco de dados.
 - BaseRepository.php → contém a conexão e consultas base.
 - Service/ → regras de negócio executadas pelas rotas.
 - Route/ e Router/ → sistema interno de roteamento da API.
 - Métodos das rotas

## Para rotas GET:

 `public function listar(array $urlParams)`

## Para rotas POST:

  `public function salvar(array $body, array $urlParams = [])`

  - O **$body** contém os dados enviados na requisição e $urlParams contém os parâmetros da URL.

# Configuração do banco

## Antes de executar o projeto, altere as configurações de conexão em:

  `BaseRepository.php`

### Atualize:

 - Host/IP
 - Usuário
 - Senha
 - Nome do banco