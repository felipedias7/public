<?php
/**
 * Gerador de XML para Imóveis - Padrão VivaReal/ZAP
 * 
 * Ferramenta simples para gerar XML de imóveis no formato
 * aceito pelos principais portais imobiliários brasileiros
 * 
 * @author Imobisoft - https://imobisoft.com.br
 * @version 1.0
 */

class GeradorXMLImoveis 
{
    private $imoveis = [];
    
    /**
     * Adiciona um imóvel ao XML
     */
    public function adicionarImovel($dados) 
    {
        // Dados obrigatórios
        $imovel = [
            'id' => $dados['id'] ?? uniqid(),
            'tipo' => $dados['tipo'] ?? 'apartamento',
            'endereco' => $dados['endereco'] ?? '',
            'cidade' => $dados['cidade'] ?? '',
            'uf' => $dados['uf'] ?? '',
            'cep' => $dados['cep'] ?? '',
            'preco' => $dados['preco'] ?? 0,
            'area' => $dados['area'] ?? 0,
            'quartos' => $dados['quartos'] ?? 0,
            'banheiros' => $dados['banheiros'] ?? 0,
            'descricao' => $dados['descricao'] ?? '',
            'fotos' => $dados['fotos'] ?? []
        ];
        
        $this->imoveis[] = $imovel;
    }
    
    /**
     * Gera o XML completo
     */
    public function gerarXML() 
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        
        // Elemento raiz
        $feed = $xml->createElement('Carga');
        $feed->setAttribute('xmlns', 'http://www.vivareal.com/schemas/1.0/VRSync');
        $xml->appendChild($feed);
        
        // Header
        $header = $xml->createElement('Header');
        $provider = $xml->createElement('Provider', 'Imobisoft');
        $email = $xml->createElement('Email', 'contato@imobisoft.com.br');
        $contactName = $xml->createElement('ContactName', 'Suporte Imobisoft');
        
        $header->appendChild($provider);
        $header->appendChild($email);
        $header->appendChild($contactName);
        $feed->appendChild($header);
        
        // Listings
        $listings = $xml->createElement('Listings');
        
        foreach ($this->imoveis as $imovel) {
            $listing = $this->criarListing($xml, $imovel);
            $listings->appendChild($listing);
        }
        
        $feed->appendChild($listings);
        
        return $xml->saveXML();
    }
    
    /**
     * Cria elemento listing individual
     */
    private function criarListing($xml, $imovel) 
    {
        $listing = $xml->createElement('Listing');
        $listing->setAttribute('xmlns', 'http://www.vivareal.com/schemas/1.0/VRSync');
        
        // Dados básicos
        $listingID = $xml->createElement('ListingID', $imovel['id']);
        $title = $xml->createElement('Title', substr($imovel['descricao'], 0, 50));
        $transactionType = $xml->createElement('TransactionType', 'For Sale');
        
        $listing->appendChild($listingID);
        $listing->appendChild($title);
        $listing->appendChild($transactionType);
        
        // Localização
        $location = $xml->createElement('Location');
        $address = $xml->createElement('Address', $imovel['endereco']);
        $city = $xml->createElement('City', $imovel['cidade']);
        $state = $xml->createElement('State', $imovel['uf']);
        $postalCode = $xml->createElement('PostalCode', $imovel['cep']);
        
        $location->appendChild($address);
        $location->appendChild($city);
        $location->appendChild($state);
        $location->appendChild($postalCode);
        $listing->appendChild($location);
        
        // Detalhes
        $details = $xml->createElement('Details');
        $propertyType = $xml->createElement('PropertyType', ucfirst($imovel['tipo']));
        $description = $xml->createElement('Description', $imovel['descricao']);
        $listPrice = $xml->createElement('ListPrice', number_format($imovel['preco'], 2, '.', ''));
        $livingArea = $xml->createElement('LivingArea', $imovel['area']);
        $bedrooms = $xml->createElement('Bedrooms', $imovel['quartos']);
        $bathrooms = $xml->createElement('Bathrooms', $imovel['banheiros']);
        
        $details->appendChild($propertyType);
        $details->appendChild($description);
        $details->appendChild($listPrice);
        $details->appendChild($livingArea);
        $details->appendChild($bedrooms);
        $details->appendChild($bathrooms);
        $listing->appendChild($details);
        
        // Fotos
        if (!empty($imovel['fotos'])) {
            $media = $xml->createElement('Media');
            foreach ($imovel['fotos'] as $foto) {
                $item = $xml->createElement('Item');
                $item->setAttribute('medium', 'image');
                $item->setAttribute('url', $foto);
                $media->appendChild($item);
            }
            $listing->appendChild($media);
        }
        
        return $listing;
    }
    
    /**
     * Salva XML em arquivo
     */
    public function salvarArquivo($nomeArquivo = 'imoveis.xml') 
    {
        $xml = $this->gerarXML();
        file_put_contents($nomeArquivo, $xml);
        return $xml;
    }
}

// ============================================= //
// -- EXEMPLO DE USO
// ============================================= //

// Cria uma instância do gerador
$gerador = new GeradorXMLImoveis();

// Adiciona alguns imóveis de exemplo
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
    'descricao' => 'Apartamento moderno com 3 quartos, 2 banheiros, área gourmet e vista para o mar.',
    'fotos' => [
        'https://exemplo.com/foto1.jpg',
        'https://exemplo.com/foto2.jpg'
    ]
]);

$gerador->adicionarImovel([
    'id' => '67890',
    'tipo' => 'casa',
    'endereco' => 'Av. Principal, 456',
    'cidade' => 'Rio de Janeiro',
    'uf' => 'RJ',
    'cep' => '22000-000',
    'preco' => 1200000,
    'area' => 200,
    'quartos' => 4,
    'banheiros' => 3,
    'descricao' => 'Casa em condomínio fechado com piscina, churrasqueira e jardim.',
    'fotos' => [
        'https://exemplo.com/casa1.jpg',
        'https://exemplo.com/casa2.jpg',
        'https://exemplo.com/casa3.jpg'
    ]
]);

// Gera e exibe o XML
header('Content-Type: application/xml; charset=utf-8');
echo $gerador->gerarXML();

// Ou salva em arquivo
// $gerador->salvarArquivo('feed_imoveis.xml');
// echo "XML gerado e salvo em feed_imoveis.xml";

?>
