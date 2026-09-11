@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? 'Lo que dicen nuestros clientes';
    $bEyebrow = $bData['eyebrow'] ?? 'Experiencias Reales';
@endphp

<!-- 7. TESTIMONIALS CAROUSEL -->
<section class="testimonials-section" id="opiniones">
    <div class="section-header">
        <div>
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 class="section-title">{{ $bTitle }}</h2>
        </div>
        <div class="carousel-arrows">
            <button class="carousel-btn" id="testPrev" aria-label="Anterior">←</button>
            <button class="carousel-btn" id="testNext" aria-label="Siguiente">→</button>
        </div>
    </div>

    <div class="testimonials-track" id="testTrack">
        <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <p class="testimonial-quote">"El pedido llegó en un empaque soberbio. La calidad de los acabados y la atención personalizada superaron ampliamente mis expectativas."</p>
            <div class="testimonial-author">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Camila R." class="testimonial-avatar">
                <div>
                    <strong>Camila Restrepo</strong>
                    <small>Compradora Verificada · CDMX</small>
                </div>
            </div>
        </div>

        <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <p class="testimonial-quote">"Compré directamente por la plataforma y la atención por WhatsApp fue inmediata y muy cordial. Excelente servicio y rapidez."</p>
            <div class="testimonial-author">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Mateo V." class="testimonial-avatar">
                <div>
                    <strong>Mateo Valenzuela</strong>
                    <small>Comprador Verificado · Zacatecas</small>
                </div>
            </div>
        </div>

        <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <p class="testimonial-quote">"Los detalles artesanales y el compromiso con la tradición zacatecana hacen que valga cada peso. Muy recomendado."</p>
            <div class="testimonial-author">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=100&q=80" alt="Lucía M." class="testimonial-avatar">
                <div>
                    <strong>Lucía Mendoza</strong>
                    <small>Compradora Verificada · Guadalajara</small>
                </div>
            </div>
        </div>

        <div class="testimonial-card">
            <div class="testimonial-stars">★★★★★</div>
            <p class="testimonial-quote">"Plataforma impecable y entrega rápida. Es un orgullo poder comprarle a los mejores negocios de Zacatecas desde un solo lugar."</p>
            <div class="testimonial-author">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=80" alt="Rodrigo S." class="testimonial-avatar">
                <div>
                    <strong>Rodrigo Santos</strong>
                    <small>Comprador Verificado · Querétaro</small>
                </div>
            </div>
        </div>
    </div>
</section>
