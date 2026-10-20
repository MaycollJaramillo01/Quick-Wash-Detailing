<section class="section-padding bg-white" id="before-after-v2">
    <div class="container">
        <div class="section-title">
            <span class="eyebrow"><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['eyebrow'] ?? ''); ?></span>
            <h2><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['title'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['desc'] ?? ''); ?></p>
        </div>

        <style>
        .ba-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        .ba-card {
            position: relative;
            aspect-ratio: 4/3;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            user-select: none;
        }
        .ba-slider {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .ba-img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
        }
        .after-img {
            clip-path: inset(0 0 0 50%);
        }
        .ba-handle {
            position: absolute;
            top: 0; bottom: 0; left: 50%; width: 4px;
            background: #fff;
            cursor: ew-resize;
            z-index: 10;
        }
        .ba-handle::before {
            content: '<>';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 40px; height: 40px;
            background: var(--accent-green);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center; justify-content: center;
            font-weight: 900;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .ba-badge {
            position: absolute;
            top: 20px;
            padding: 6px 12px;
            background: rgba(0,0,0,0.7);
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            border-radius: 4px;
        }
        .badge-before { left: 20px; }
        .badge-after { right: 20px; background: var(--accent-green); }
        </style>

        <div class="ba-grid">
            <!-- Item 1: Interior -->
            <div class="ba-card">
                <div class="ba-slider">
                    <img src="assets/img/gallery/before-after/before-1.jpg" class="ba-img before-img" alt="<?php echo htmlspecialchars($ProjectsBeforeAfterCopy['before_label'] ?? ''); ?>">
                    <img src="assets/img/gallery/before-after/after-1.jpg" class="ba-img after-img" alt="<?php echo htmlspecialchars($ProjectsBeforeAfterCopy['after_label'] ?? ''); ?>">
                    <div class="ba-handle"></div>
                    <span class="ba-badge badge-before"><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['before_label'] ?? ''); ?></span>
                    <span class="ba-badge badge-after"><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['after_label'] ?? ''); ?></span>
                </div>
            </div>
            
             <!-- Item 2: Exterior -->
            <div class="ba-card">
                <div class="ba-slider">
                    <img src="assets/img/gallery/before-after/before-2.jpg" class="ba-img before-img" alt="<?php echo htmlspecialchars($ProjectsBeforeAfterCopy['before_label'] ?? ''); ?>">
                    <img src="assets/img/gallery/before-after/after-2.jpg" class="ba-img after-img" alt="<?php echo htmlspecialchars($ProjectsBeforeAfterCopy['after_label'] ?? ''); ?>">
                    <div class="ba-handle"></div>
                    <span class="ba-badge badge-before"><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['before_label'] ?? ''); ?></span>
                    <span class="ba-badge badge-after"><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['after_label'] ?? ''); ?></span>
                </div>
            </div>
            
             <!-- Item 3: Flooring -->
            <div class="ba-card">
                <div class="ba-slider">
                    <img src="assets/img/gallery/before-after/before-3.jpg" class="ba-img before-img" alt="<?php echo htmlspecialchars($ProjectsBeforeAfterCopy['before_label'] ?? ''); ?>">
                    <img src="assets/img/gallery/before-after/after-3.jpg" class="ba-img after-img" alt="<?php echo htmlspecialchars($ProjectsBeforeAfterCopy['after_label'] ?? ''); ?>">
                    <div class="ba-handle"></div>
                    <span class="ba-badge badge-before"><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['before_label'] ?? ''); ?></span>
                    <span class="ba-badge badge-after"><?php echo htmlspecialchars($ProjectsBeforeAfterCopy['after_label'] ?? ''); ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.querySelectorAll('.ba-card').forEach(card => {
        const slider = card.querySelector('.ba-slider');
        const afterImg = card.querySelector('.after-img');
        const handle = card.querySelector('.ba-handle');
        
        const move = (e) => {
            const rect = slider.getBoundingClientRect();
            const x = (e.touches ? e.touches[0].clientX : e.clientX) - rect.left;
            let percent = (x / rect.width) * 100;
            percent = Math.max(0, Math.min(100, percent));
            
            afterImg.style.clipPath = `inset(0 0 0 ${percent}%)`;
            handle.style.left = `${percent}%`;
        };
        
        slider.addEventListener('mousemove', move);
        slider.addEventListener('touchmove', move);
    });
    </script>
</section>
