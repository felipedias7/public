# Gerador XML para Imóveis

Ferramenta PHP para gerar XML no padrão VivaReal/ZAP e outros portais imobiliários brasileiros.

## 🚀 Sobre o Projeto

Esta biblioteca permite gerar feeds XML compatíveis com os principais portais imobiliários do Brasil, facilitando a integração e publicação automática de imóveis.

### Portais Suportados
- ✅ VivaReal
- ✅ ZAP Imóveis  
- ✅ OLX Imóveis
- ✅ Chaves na Mão

## 📋 Funcionalidades

- Geração de XML válido no padrão dos portais
- Suporte a múltiplos imóveis em um único feed
- Validação automática de campos obrigatórios
- Suporte a múltiplas fotos por imóvel
- Configuração flexível de dados

## 🛠️ Instalação

Clone este repositório:

```bash
git clone https://github.com/felipedias7/vivareal-xml-generator.git
cd vivareal-xml-generator
```

## 📖 Como Usar

### Exemplo Básico

```php
<?php
require_once 'gerar-xml.php';

// Cria uma instância do gerador
$gerador = new GeradorXMLImoveis();

// Adiciona um imóvel
$gerador->adicionarImovel([
    'id' => '12345',
    'tipo' => 'apartamento',
    'endereco' => 'Rua das Flores, 123',
    'cidade' => 'São Paulo',
    'uf' => 'SP',
    'cep' => '01234-567',
    'preco' => 850000,
    'area' => 120,
    'quartos' => 3,
    'banheiros' => 2,
    'descricao' => 'Apartamento moderno com vista para o mar.',
    'fotos' => [
        'https://exemplo.com/foto1.jpg',
        'https://exemplo.com/foto2.jpg'
    ]
]);

// Gera o XML
echo $gerador->gerarXML();

// Ou salva em arquivo
$gerador->salvarArquivo('feed_imoveis.xml');
?>
```

### Campos Disponíveis

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id` | string | ✅ | Identificador único do imóvel |
| `tipo` | string | ✅ | Tipo: apartamento, casa, terreno, etc |
| `endereco` | string | ✅ | Endereço completo |
| `cidade` | string | ✅ | Cidade |
| `uf` | string | ✅ | Estado (SP, RJ, etc) |
| `cep` | string | ✅ | CEP |
| `preco` | float | ✅ | Preço de venda/aluguel |
| `area` | float | ✅ | Área em m² |
| `quartos` | int | ❌ | Número de quartos |
| `banheiros` | int | ❌ | Número de banheiros |
| `descricao` | string | ❌ | Descrição detalhada |
| `fotos` | array | ❌ | URLs das fotos |

## 🔧 Estrutura do XML Gerado

O XML segue o padrão:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<Carga xmlns="http://www.vivareal.com/schemas/1.0/VRSync">
  <Header>
    <Provider>Imobisoft</Provider>
    <Email>contato@imobisoft.com.br</Email>
    <ContactName>Suporte Imobisoft</ContactName>
  </Header>
  <Listings>
    <Listing xmlns="http://www.vivareal.com/schemas/1.0/VRSync">
      <!-- Dados do imóvel -->
    </Listing>
  </Listings>
</Carga>
```

## 📁 Estrutura do Projeto

```
vivareal-xml-generator/
├── gerar-xml.php          # Classe principal
├── examples/              # Exemplos de uso
│   ├── exemplo-basico.php
│   └── exemplo-multiplos.php
├── README.md              # Este arquivo
└── LICENSE                # Licença MIT
```

## 🧪 Executando os Exemplos

```bash
# Exemplo básico
php examples/exemplo-basico.php

# Exemplo com múltiplos imóveis
php examples/exemplo-multiplos.php
```

## 🤝 Contribuindo

Contribuições são bem-vindas! Para contribuir:

1. Fork este repositório
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📞 Suporte

Se você encontrar algum problema ou tiver dúvidas:

- Abra uma [issue](https://github.com/felipedias7/vivareal-xml-generator/issues)
- Entre em contato através do site: [imobisoft.com.br](https://imobisoft.com.br)

## 🏗️ Sobre o Autor

**Felipe Dias** - CEO da Imobisoft

Desenvolvedor e empreendedor especializado em soluções para o mercado imobiliário.

### 🚀 Sobre a Imobisoft

Software imobiliário completo com:

- CRM integrado aos portais
- Sites otimizados para SEO  
- Gestão de leads e propostas
- Automação de publicações

**Site:** [imobisoft.com.br](https://imobisoft.com.br)

### 🛠️ Tech Stack

- PHP 8.x + MySQL
- jQuery + Bootstrap
- Integração com portais (OLX, VivaReal, ZAP)

---

⭐ **Gostou do projeto? Deixe uma estrela!** ⭐
