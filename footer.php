<footer style="border-top:1px solid #E2E8F0;background:#fff;margin-top:auto">
  <div class="container" style="padding-top:24px;padding-bottom:24px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">
    <div style="display:flex;align-items:center;gap:8px">
      <div style="width:26px;height:26px;background:#1E3A8A;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px">✓</div>
      <span style="font-family:'Sora',sans-serif;font-weight:700;color:#1E3A8A;font-size:15px">SmartTest</span>
    </div>
    <p style="font-size:12px;color:#94A3B8">Adaptiv Intellekt Test Platformasi &copy; <?= date('Y') ?></p>
  </div>
</footer>
<?php if(isset($flashDelay)): ?>
<script>setTimeout(()=>{document.querySelectorAll('.fixed-top').forEach(e=>e.remove())},3000)</script>
<?php endif; ?>
</body></html>
