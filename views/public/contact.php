<div style="max-width: 900px; margin: 0 auto;">
    <h1><?= htmlspecialchars($heading ?? 'Contact Us', ENT_QUOTES, 'UTF-8') ?></h1>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum ratione officia libero maiores, explicabo cumque
        dolorem quasi rerum molestiae. Ex ut tempora odit voluptatem, libero culpa nostrum dolores enim velit magnam
        repellendus! Porro repudiandae mollitia odit eveniet molestias consequuntur deleníti quisquam ducimus quidem
        autem? Error culpa nostrum, nemo quo quisquam illo architecto id nihil pariatur esse recusandae alias quaerat
        voluptates iure consequuntur repellat cupiditate perferendis iste praesentium. Suscipit, molestias consequatur.
    </p>

    <hr style="margin: 40px 0; border: none; border-top: 1px solid #ddd;">

    <h2>Get in Touch</h2>

    <form method="POST" action="/whey_web/contact" style="max-width: 600px; margin: 30px 0;">
        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600;">Name</label>
            <input type="text" id="name" name="name" placeholder="Your name" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
            <input type="email" id="email" name="email" placeholder="Your email" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="subject" style="display: block; margin-bottom: 8px; font-weight: 600;">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Message subject" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="message" style="display: block; margin-bottom: 8px; font-weight: 600;">Message</label>
            <textarea id="message" name="message" placeholder="Your message" rows="6" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
        </div>

        <button type="submit"
            style="background-color: #0066cc; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Send
            Message</button>
    </form>
</div>