<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden; background: #fff;">
                <div class="row g-0">
                    <?php if (!empty($about['about_image'])): ?>
                        <div class="col-md-5">
                            <img src="<?= asset('uploads/' . htmlspecialchars($about['about_image'])) ?>"
                                class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 400px;"
                                alt="About FITWHEY">
                        </div>
                    <?php endif; ?>

                    <div class="<?= !empty($about['about_image']) ? 'col-md-7' : 'col-12' ?> p-5">
                        <h1 class="fw-bold mb-4"
                            style="color: #333; border-bottom: 3px solid #10B981; display: inline-block; padding-bottom: 10px;">
                            <?= htmlspecialchars($about['about_title'] ?? 'Giới thiệu về chúng tôi') ?>
                        </h1>

                        <?php if (!empty($about['about_slogan'])): ?>
                            <p class="text-muted fst-italic mb-4"
                                style="border-left: 4px solid #10B981; padding-left: 15px; font-size: 1.1rem;">
                                "<?= htmlspecialchars($about['about_slogan']) ?>"
                            </p>
                        <?php endif; ?>

                        <div class="about-content" style="line-height: 1.8; color: #555; font-size: 1.05rem;">
                            <?= nl2br(htmlspecialchars($about['about_content'] ?? 'Nội dung đang được cập nhật...')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>