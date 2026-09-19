<?php

include 'location_util.php';

$countryCode = isset($_GET['for_country']) ? $_GET['for_country'] : getVisitorCountryCode();

$pricesInEur = ["€80", "€150", "€280", "€130", "€200", "€20", "€120"];
$pricesInKwz = ["20 000 Kz", "38 000 Kz", "72 000 Kz", "55 000 Kz", "70 000 Kz", "8 000 Kz", "30 000 Kz"];
$prices = ["-", "-", "-"];

if ($countryCode == "AO") {
    $prices = $pricesInKwz;
} else {
    $prices = $pricesInEur;
}

$emailLink = "<a href='mailto:wykimonii@gmail.com' class='action-button'>Marcar sessão aqui</a>";

echo("
<h2 id='consultas'>Clinica</h2>

<div class='pricebox-container'>

    <div class='pricebox'>
        <h1>Plano Transformação – Mais Escolhido</h1>
        <div class='price-row'>
            <h2>{$prices[2]}</h2>
            <p>Podes pagar 2x <br> antes da última sessão</p>
        </div>
        <ul>
        <li>4 sessões - cada 50 min</li><br>
        <li>⁠Acompanhamento contínuo e aprofundado</li><br>
        <li>⁠Compromisso real com o teu bem-estar</li><br>
        <li>⁠Espaço seguro para transformação pessoal</li><br>
        </ul>
        <span class='golden-text-sub'> Ideal para quem decide investir seriamente em si.</span>
        {$emailLink}
    </div>

    <div class='pricebox'>
        <h1>Plano Continuidade</h1>
        <h2>{$prices[1]}</h2>
        <ul>
        <li>2 sessões - cada 50 min</li><br>
        <li>⁠Acompanhamento regular</li><br>
        <li>⁠Estrutura e continuidade</li><br>
        <li>⁠Apoio consistente ao longo do mês</li><br>
        </ul>
        <span class='golden-text-sub'>Ideal para quem quer mudar com consistência e apoio.</span>
        {$emailLink}
    </div>

    <div class='pricebox'>
        <h1>Sessão única intensiva</h1>
        <h2>{$prices[6]}</h2>
        <ul>
        <li>1 sessão - 90 min</li><br>
        <li>⁠Identificação dos bloqueios principais</li><br>
        <li>⁠Clareza sobre as áreas da vida a mudar</li><br>
        <li>⁠Direção prática para começares a agir</li><br>
        </ul>
        <span class='golden-text-sub'>Ideal para quem quer mudança sem um processo longo.</span>
        {$emailLink}
    </div>

    <div class='pricebox'>
        <h1>Consulta individual</h1>
        <h2>{$prices[0]}</h2>
        <ul>
        <li>1 sessão - 50 min</li><br>
        <li>⁠Sessão completa de apoio emocional</li><br>
        <li>⁠Trabalho focado numa questão específica</li><br>
        <li>⁠Escuta profunda e orientação profissional</li><br>
        </ul>
        <span class='golden-text-sub'>Ideal para quem precisa de apoio completo num momento concreto.</span>
        {$emailLink}
    </div>

    <div class='pricebox'>
        <h1>Sessão Primeiro Passo</h1>
        <h2>{$prices[5]}</h2>
        <ul>
        <li>1 sessão - 15 min</li><br>
        <li>⁠Espaço seguro para falares do que te preocupa</li><br>
        <li>⁠Clareza sobre o que te está a bloquear</li><br>
        <li>⁠Orientação para o melhor próximo passo</li><br>
        </ul>
        <p class='golden-text-sub'>Ideal se estás indeciso(a) ou não sabes por onde começar.</p>
        {$emailLink}
    </div>

    <div class='pricebox'>
        <h1>Workshops que transformam</h1>
        <h2>Brevemente</h2>
        <p style='text-align:left; font-size:17px;'>Alguns dos workshops já realizados:</p>
        <ul>
        <li>Resolução de conflitos</li><br>
        <li>⁠Treino de liderança</li><br>
        <li>⁠⁠Como aplicar a TCC em contexto clínico</li><br>
        <li>⁠Saúde mental para profissionais de saúde</li><br>
        <li>⁠⁠Como trabalhar sob pressão</li><br>
        </ul>
        <p class='golden-text-sub'>Cada workshop é adaptado ao teu objetivo, seja na promoção da saúde mental no trabalho ou no desenvolvimento de competências emocionais em contextos educativos e comunitários.</p>
        {$emailLink}
    </div>

    <div class='pricebox'>
    <h1>Formação específica</h1>
        <div class='section'>
            <h3>
            Atração e construção de um relacionamento saudável
            <button class='toggle-btn'>+</button>
            </h3>
            <ul class='accordion-content'>
            <li>Identificar padrões saboradores e red flags emocionais</li>
            <li>Estabelecer limites e comunicar com clareza</li>
            <li>Reconhecer o que é um amor saudável</li>
            <li>Criar ou aumentar o teu valor e atração para um futuro parceiro.</li>
            </ul>
            <div class='price-row'>
                <h2>{$prices[3]}</h2>
                <p>Podes pagar 2x – antes da última sessão</p>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <div class='section'>
            <h3>
            Como ser psicólogo : Um guia prático
            <button class='toggle-btn'>+</button>
            </h3>
            <ul class='accordion-content'>
            <li>Formação prática para recém-formados em psicologia que querem iniciar a carreira com confiança.</li>
            <li>Noções básicas de como dar sessões.</li>
            </ul>
            <div class='price-row'>
                <h2>{$prices[4]}</h2>
                <p>Podes pagar 2x – antes da última sessão</p>
            </div>
        </div>
        {$emailLink}
    </div>

    <div class='pricebox'>
        <h1>Psicologia de Bem-estar corporativo</h1>
        <h2>Brevemente</h2>
        <ul>
        <li>Sob consulta<br> Envie email para : wykimonii@gmail.com</li><br>
        </ul>
        {$emailLink}
    </div>
</div>

<script>
document.querySelectorAll('.section').forEach(section => {
  const btn = section.querySelector('.toggle-btn');
  const content = section.querySelector('.accordion-content');
  const header = section.querySelector('h3');

  // Initialize
  content.style.height = '0';
  content.style.overflow = 'hidden';
  content.style.transition = 'height 0.3s ease';

  header.addEventListener('click', () => {
    if (content.style.height !== '0px') {
      // Collapse
      content.style.height = '0';
      btn.textContent = '+';
    } else {
      // Expand
      content.style.height = content.scrollHeight + 'px';
      btn.textContent = '−';
    }
  });
});
</script>
<br>
O pagamento pode ser feito para uma conta kuanzas, dólares, libras ou euros.<br>
Entre em contacto para mais informações: <b>wykimonii@gmail.com</b>
");
?>