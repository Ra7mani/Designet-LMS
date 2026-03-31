<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>DesignLMS — Apprenez. Créez. Décrolez.</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
<style>
/* ═══════════════════════════════════════
   VARIABLES & RESET
═══════════════════════════════════════ */
:root{
  --violet:#7C3AED; --violet-l:#A78BFA; --violet-xl:#EDE9FE; --violet-dark:#4C1D95;
  --teal:#0D9488;   --teal-l:#2DD4BF;   --teal-xl:#CCFBF1;  --teal-dark:#134E4A;
  --indigo:#4F46E5; --indigo-l:#818CF8; --indigo-xl:#E0E7FF; --indigo-dark:#1E1B4B;
  --rose:#DB2777;   --amber:#D97706;    --emerald:#059669;
  --bg:#FAFAFA; --white:#fff; --txt:#1E1B4B; --muted:#6B7280;
  --r:20px; --rm:14px; --rs:10px; --rp:999px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--txt);overflow-x:hidden;}
a{text-decoration:none;color:inherit;}
img{max-width:100%;}

/* ═══════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════ */
@keyframes fadeUp{from{opacity:0;transform:translateY(32px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
@keyframes floatSlow{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-18px) rotate(3deg)}}
@keyframes spin{to{transform:rotate(360deg)}}
@keyframes gradShift{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
@keyframes blobPulse{0%,100%{border-radius:60% 40% 30% 70%/60% 30% 70% 40%}50%{border-radius:30% 60% 70% 40%/50% 60% 30% 60%}}
@keyframes countUp{from{opacity:0;transform:scale(.5)}to{opacity:1;transform:scale(1)}}
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
@keyframes slideIn{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
@keyframes popIn{0%{transform:scale(0);opacity:0}80%{transform:scale(1.1)}100%{transform:scale(1);opacity:1}}

.reveal{opacity:0;transform:translateY(32px);transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1);}
.reveal.visible{opacity:1;transform:translateY(0);}
.reveal-left{opacity:0;transform:translateX(-40px);transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1);}
.reveal-left.visible{opacity:1;transform:translateX(0);}
.reveal-right{opacity:0;transform:translateX(40px);transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1);}
.reveal-right.visible{opacity:1;transform:translateX(0);}

/* ═══════════════════════════════════════
   NAV
═══════════════════════════════════════ */
.nav{
  position:fixed;top:0;left:0;right:0;z-index:999;
  padding:16px 5%;
  display:flex;align-items:center;justify-content:space-between;
  transition:all .3s;
}
.nav.scrolled{
  background:rgba(255,255,255,.92);backdrop-filter:blur(20px);
  box-shadow:0 2px 30px rgba(124,58,237,.1);
  padding:12px 5%;
}
.nav-logo{display:flex;align-items:center;gap:10px;cursor:pointer;}
.nav-logo-icon{
  width:42px;height:42px;border-radius:14px;
  background:linear-gradient(135deg,#7C3AED,#0D9488);
  display:flex;align-items:center;justify-content:center;font-size:20px;
  box-shadow:0 4px 14px rgba(124,58,237,.3);
}
.nav-logo-text{font-family:'Poppins',sans-serif;font-weight:900;font-size:18px;
  background:linear-gradient(135deg,#7C3AED,#0D9488);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.nav-links{display:flex;align-items:center;gap:32px;}
.nav-link{font-size:14px;font-weight:500;color:var(--muted);transition:color .2s;cursor:pointer;}
.nav-link:hover{color:var(--violet);}
.nav-actions{display:flex;align-items:center;gap:12px;}
.btn-nav-ghost{padding:8px 18px;border-radius:var(--rp);font-size:13px;font-weight:600;color:var(--violet);border:1.5px solid rgba(124,58,237,.25);background:transparent;cursor:pointer;transition:all .2s;}
.btn-nav-ghost:hover{background:var(--violet-xl);}
.btn-nav-primary{padding:9px 22px;border-radius:var(--rp);font-size:13px;font-weight:700;color:#fff;background:linear-gradient(135deg,#7C3AED,#0D9488);border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 14px rgba(124,58,237,.25);}
.btn-nav-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(124,58,237,.35);}
.nav-mobile-btn{display:none;background:none;border:none;cursor:pointer;font-size:22px;}

/* ═══════════════════════════════════════
   HERO
═══════════════════════════════════════ */
.hero{
  min-height:100vh;display:flex;align-items:center;
  padding:120px 5% 80px;
  position:relative;overflow:hidden;
  background:linear-gradient(160deg,#FAFAFA 0%,#F5F3FF 40%,#F0FDFA 100%);
}
.hero-bg-blob{
  position:absolute;pointer-events:none;
}
.blob1{
  width:600px;height:600px;top:-200px;right:-100px;
  background:radial-gradient(ellipse,rgba(124,58,237,.12) 0%,transparent 70%);
  animation:blobPulse 8s ease-in-out infinite;border-radius:60% 40% 30% 70%/60% 30% 70% 40%;
}
.blob2{
  width:500px;height:500px;bottom:-150px;left:-100px;
  background:radial-gradient(ellipse,rgba(13,148,136,.10) 0%,transparent 70%);
  animation:blobPulse 10s ease-in-out infinite reverse;border-radius:40% 60% 70% 30%/40% 50% 60% 50%;
}
.blob3{
  width:300px;height:300px;top:30%;left:35%;
  background:radial-gradient(ellipse,rgba(79,70,229,.08) 0%,transparent 70%);
  animation:blobPulse 12s ease-in-out infinite;border-radius:50%;
}
.hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;max-width:1200px;margin:0 auto;width:100%;position:relative;z-index:1;}
.hero-badge{
  display:inline-flex;align-items:center;gap:8px;
  background:rgba(124,58,237,.1);border:1.5px solid rgba(124,58,237,.2);
  border-radius:var(--rp);padding:6px 16px;font-size:12px;font-weight:700;color:var(--violet);
  margin-bottom:20px;animation:fadeUp .6s .1s both;
}
.hero-badge-dot{width:7px;height:7px;border-radius:50%;background:var(--violet);animation:spin 2s linear infinite;}
.hero-title{
  font-family:'Syne',sans-serif;font-size:clamp(40px,5vw,64px);font-weight:800;line-height:1.1;
  color:var(--txt);margin-bottom:20px;animation:fadeUp .6s .2s both;
}
.hero-title-grad{
  background:linear-gradient(135deg,#7C3AED 0%,#0D9488 60%,#4F46E5 100%);
  background-size:200% auto;
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  animation:gradShift 4s linear infinite;
}
.hero-sub{font-size:17px;color:var(--muted);line-height:1.7;max-width:520px;margin-bottom:36px;animation:fadeUp .6s .3s both;}
.hero-sub strong{color:var(--txt);}
.hero-cta-row{display:flex;align-items:center;gap:14px;flex-wrap:wrap;animation:fadeUp .6s .4s both;}
.btn-hero-primary{
  padding:15px 32px;border-radius:var(--rp);font-size:15px;font-weight:700;color:#fff;
  background:linear-gradient(135deg,#7C3AED,#0D9488);border:none;cursor:pointer;
  box-shadow:0 8px 28px rgba(124,58,237,.35);transition:all .3s;
  display:inline-flex;align-items:center;gap:8px;
}
.btn-hero-primary:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(124,58,237,.45);}
.btn-hero-outline{
  padding:14px 28px;border-radius:var(--rp);font-size:15px;font-weight:600;color:var(--violet);
  background:transparent;border:2px solid rgba(124,58,237,.3);cursor:pointer;transition:all .2s;
  display:inline-flex;align-items:center;gap:8px;
}
.btn-hero-outline:hover{background:var(--violet-xl);border-color:var(--violet);}
.hero-trust{display:flex;align-items:center;gap:10px;margin-top:22px;font-size:12px;color:var(--muted);animation:fadeUp .6s .5s both;}
.hero-avatars{display:flex;}
.hero-av{width:28px;height:28px;border-radius:50%;border:2px solid #fff;margin-left:-8px;font-size:10px;font-weight:700;color:#fff;display:flex;align-items:center;justify-content:center;}
.hero-av:first-child{margin-left:0;}
.hero-stars{color:#F59E0B;font-size:13px;}

/* Hero right — cards layout */
.hero-right{
  position:relative;
  width:100%;
  max-width:700px;
  margin:0 auto;
  animation:fadeUp .7s .3s both;
}
.hero-cards-grid{
  position:relative;
  width:100%;
  height:640px;
}
.hero-mockup-main{
  position:absolute;
  top:10px;
  left:36%;
  transform:translateX(-50%);
  width:340px;
  z-index:3;
  background:#fff;border-radius:24px;padding:24px;
  backdrop-filter:blur(4px);
  box-shadow:0 20px 60px rgba(124,58,237,.18),0 4px 20px rgba(0,0,0,.05);
  border:1.5px solid rgba(124,58,237,.08);
  animation:float 5.2s ease-in-out infinite;
}
.mock-header{display:flex;align-items:center;gap:10px;margin-bottom:18px;}
.mock-av{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:#fff;}
.mock-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);}
.mock-sub{font-size:11px;color:var(--muted);}
.mock-prog-label{display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px;}
.mock-prog-bar{height:8px;background:#F3F4F6;border-radius:99px;overflow:hidden;}
.mock-prog-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#7C3AED,#0D9488);}
.mock-chips{display:flex;gap:6px;flex-wrap:wrap;margin-top:14px;}
.mock-chip{padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600;}

.hero-card-float{
  position:absolute;
  background:#fff;border-radius:20px;padding:16px 18px;
  backdrop-filter:blur(6px);
  box-shadow:0 16px 38px rgba(15,23,42,.14);
  border:1.5px solid rgba(0,0,0,.05);
  transition:transform .3s ease, box-shadow .3s ease;
  animation:float 4.8s ease-in-out infinite;
}
.hero-card-float:hover{
  transform:translateY(-3px) scale(1.03);
  box-shadow:0 22px 44px rgba(15,23,42,.18);
}
.hcf1{top:330px;left:10px;width:190px;z-index:2;animation-delay:0s;}
.hcf2{top:220px;right:-6px;width:168px;z-index:4;animation-delay:1s;}
.hcf3{top:400px;right:4px;width:182px;z-index:2;animation-delay:2s;}

/* ═══════════════════════════════════════
   STATS BAND
═══════════════════════════════════════ */
.stats-band{
  background:linear-gradient(135deg,#1E1B4B 0%,#4C1D95 50%,#134E4A 100%);
  padding:48px 5%;
}
.stats-band-inner{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;max-width:1100px;margin:0 auto;}
.stat-item{text-align:center;padding:20px;}
.stat-num{font-family:'Syne',sans-serif;font-size:clamp(28px,4vw,46px);font-weight:800;color:#fff;margin-bottom:4px;background:linear-gradient(90deg,#A78BFA,#2DD4BF);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.stat-lbl{font-size:13px;color:rgba(255,255,255,.6);font-weight:500;}
.stat-sep{width:1px;background:rgba(255,255,255,.12);margin:10px auto;}

/* ═══════════════════════════════════════
   FEATURES — PERSONAS
═══════════════════════════════════════ */
.section{padding:90px 5%;max-width:1200px;margin:0 auto;}
.section-badge{display:inline-flex;align-items:center;gap:6px;border-radius:var(--rp);padding:5px 14px;font-size:11px;font-weight:700;margin-bottom:14px;}
.section-title{font-family:'Syne',sans-serif;font-size:clamp(28px,4vw,46px);font-weight:800;color:var(--txt);line-height:1.15;margin-bottom:16px;}
.section-sub{font-size:16px;color:var(--muted);line-height:1.7;max-width:580px;}

.personas-grid{
  display:grid;
  grid-template-columns:repeat(2,minmax(280px,420px));
  justify-content:center;
  gap:24px;
  margin-top:52px;
}
.persona-card{
  border-radius:24px;padding:32px 28px;position:relative;overflow:hidden;
  transition:all .3s cubic-bezier(.22,1,.36,1);cursor:pointer;
  border:1.5px solid transparent;
}
.persona-card:hover{transform:translateY(-8px);}
.persona-card.student{background:linear-gradient(160deg,#F5F3FF 0%,#EDE9FE 100%);border-color:rgba(124,58,237,.15);}
.persona-card.student:hover{box-shadow:0 24px 60px rgba(124,58,237,.2);}
.persona-card.trainer{background:linear-gradient(160deg,#F0FDFA 0%,#CCFBF1 100%);border-color:rgba(13,148,136,.15);}
.persona-card.trainer:hover{box-shadow:0 24px 60px rgba(13,148,136,.2);}
.persona-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;}
.persona-card.student::before{background:linear-gradient(90deg,#7C3AED,#A78BFA);}
.persona-card.trainer::before{background:linear-gradient(90deg,#0D9488,#2DD4BF);}
.persona-emoji{font-size:44px;margin-bottom:16px;display:block;animation:float 4s ease-in-out infinite;}
.persona-title{font-family:'Poppins',sans-serif;font-size:21px;font-weight:800;color:var(--txt);margin-bottom:10px;}
.persona-desc{font-size:14px;color:var(--muted);line-height:1.7;margin-bottom:20px;}
.persona-features{display:flex;flex-direction:column;gap:8px;}
.pf-item{display:flex;align-items:center;gap:9px;font-size:13px;color:var(--txt);font-weight:500;}
.pf-check{width:20px;height:20px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0;}
.student .pf-check{background:#EDE9FE;color:#7C3AED;}
.trainer .pf-check{background:#CCFBF1;color:#0D9488;}
.persona-cta{
  display:inline-flex;align-items:center;gap:6px;
  margin-top:24px;font-size:13px;font-weight:700;
  padding:10px 20px;border-radius:var(--rp);border:none;cursor:pointer;transition:all .2s;
}
.student .persona-cta{background:#7C3AED;color:#fff;}
.trainer .persona-cta{background:#0D9488;color:#fff;}
.persona-cta:hover{opacity:.85;transform:translateX(3px);}

/* ═══════════════════════════════════════
   FEATURES GRID
═══════════════════════════════════════ */
.features-wrap{padding:90px 5%;background:linear-gradient(180deg,#fff 0%,#F5F3FF 100%);}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:52px;max-width:1200px;margin-left:auto;margin-right:auto;}
.feat-card{
  background:#fff;border-radius:20px;padding:28px;
  border:1.5px solid rgba(0,0,0,.06);
  transition:all .25s cubic-bezier(.22,1,.36,1);
  position:relative;overflow:hidden;
}
.feat-card:hover{transform:translateY(-5px);box-shadow:0 16px 40px rgba(124,58,237,.12);}
.feat-card::before{content:'';position:absolute;inset:0;border-radius:20px;background:linear-gradient(135deg,var(--fc1,#7C3AED),var(--fc2,#0D9488));opacity:0;transition:opacity .3s;}
.feat-card:hover::before{opacity:.03;}
.feat-ico{font-size:32px;margin-bottom:14px;display:block;animation:float 4s ease-in-out infinite;}
.feat-title{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);margin-bottom:8px;}
.feat-desc{font-size:13px;color:var(--muted);line-height:1.65;}
.feat-tag{display:inline-block;font-size:10px;font-weight:700;padding:3px 9px;border-radius:99px;margin-top:12px;}

/* ═══════════════════════════════════════
   COURS SHOWCASE
═══════════════════════════════════════ */
.courses-wrap{padding:90px 5%;max-width:1200px;margin:0 auto;}
.courses-scroll{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:48px;}
.course-card{
  background:#fff;border-radius:20px;overflow:hidden;
  border:1.5px solid rgba(0,0,0,.06);transition:all .25s cubic-bezier(.22,1,.36,1);
  cursor:pointer;
}
.course-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(0,0,0,.1);}
.cc-cover{height:130px;display:flex;align-items:center;justify-content:center;font-size:52px;position:relative;}
.cc-badge{position:absolute;top:10px;right:10px;font-size:10px;font-weight:700;padding:3px 8px;border-radius:99px;}
.cc-body{padding:16px;}
.cc-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px;}
.cc-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);margin-bottom:6px;line-height:1.3;}
.cc-meta{font-size:11px;color:var(--muted);margin-bottom:10px;}
.cc-footer{display:flex;align-items:center;justify-content:space-between;}
.cc-price{font-family:'Poppins',sans-serif;font-size:16px;font-weight:800;color:var(--violet);}
.cc-rating{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;}

/* ═══════════════════════════════════════
   TESTIMONIALS
═══════════════════════════════════════ */
.testimonials-wrap{padding:90px 5%;background:#fff;}
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:52px;max-width:1200px;margin-left:auto;margin-right:auto;}
.testi-card{
  background:var(--bg);border-radius:20px;padding:28px;
  border:1.5px solid rgba(0,0,0,.05);transition:all .2s;
  position:relative;
}
.testi-card:hover{transform:translateY(-4px);box-shadow:0 12px 36px rgba(0,0,0,.07);}
.testi-stars{font-size:16px;color:#F59E0B;margin-bottom:12px;}
.testi-text{font-size:14px;color:var(--muted);line-height:1.7;margin-bottom:18px;font-style:italic;}
.testi-text strong{color:var(--txt);}
.testi-author{display:flex;align-items:center;gap:10px;}
.testi-av{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#fff;flex-shrink:0;}
.testi-name{font-size:13px;font-weight:700;color:var(--txt);}
.testi-role{font-size:11px;color:var(--muted);margin-top:1px;}
.quote-mark{position:absolute;top:16px;right:20px;font-size:48px;color:rgba(124,58,237,.08);font-family:Georgia,serif;line-height:1;}

/* ═══════════════════════════════════════
   PRICING
═══════════════════════════════════════ */
.pricing-wrap{padding:90px 5%;background:linear-gradient(160deg,#F5F3FF 0%,#F0FDFA 100%);}
.pricing-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;margin-top:52px;max-width:900px;margin-left:auto;margin-right:auto;}
.price-card{
  background:#fff;border-radius:24px;padding:36px 28px;
  border:1.5px solid rgba(0,0,0,.07);
  transition:all .25s;position:relative;overflow:hidden;
}
.price-card.popular{
  border-color:var(--violet);
  box-shadow:0 16px 48px rgba(124,58,237,.2);
  transform:scale(1.04);
}
.price-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(0,0,0,.1);}
.price-card.popular:hover{transform:scale(1.04) translateY(-6px);}
.popular-badge{position:absolute;top:18px;right:18px;background:linear-gradient(135deg,#7C3AED,#0D9488);color:#fff;font-size:10px;font-weight:700;padding:4px 12px;border-radius:99px;}
.price-name{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:#111827;margin-bottom:8px;}
.price-val{font-family:'Syne',sans-serif;font-size:46px;font-weight:800;color:var(--txt);line-height:1;margin-bottom:4px;}
.price-val span{font-size:18px;font-weight:600;color:#111827;}
.price-period{font-size:12px;color:#111827;margin-bottom:24px;}
.price-features{display:flex;flex-direction:column;gap:10px;margin-bottom:28px;}
.pf{display:flex;align-items:center;gap:10px;font-size:13px;color:#111827;}
.pf-ok{color:#059669;font-size:16px;}
.pf-no{color:#D1D5DB;font-size:16px;}
.btn-price{width:100%;padding:14px;border-radius:var(--rp);font-size:14px;font-weight:700;cursor:pointer;border:none;transition:all .25s;}
.btn-price-outline{background:transparent;color:var(--violet);border:2px solid rgba(124,58,237,.25);}
.btn-price-outline:hover{background:var(--violet-xl);}
.btn-price-primary{background:linear-gradient(135deg,#7C3AED,#0D9488);color:#fff;box-shadow:0 6px 20px rgba(124,58,237,.3);}
.btn-price-primary:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(124,58,237,.4);}

/* ═══════════════════════════════════════
   INSCRIPTION — HERO CTA
═══════════════════════════════════════ */
.signup-section{
  padding:90px 5%;
  background:linear-gradient(135deg,#1E1B4B 0%,#4C1D95 40%,#134E4A 100%);
  position:relative;overflow:hidden;
}
.signup-bg-circle{position:absolute;border-radius:50%;pointer-events:none;}
.sc1{width:500px;height:500px;top:-200px;right:-150px;background:rgba(124,58,237,.15);}
.sc2{width:400px;height:400px;bottom:-150px;left:-100px;background:rgba(13,148,136,.12);}
.sc3{width:200px;height:200px;top:40%;left:40%;background:rgba(255,255,255,.03);}
.signup-inner{max-width:700px;margin:0 auto;text-align:center;position:relative;z-index:1;}
.signup-title{font-family:'Syne',sans-serif;font-size:clamp(30px,4vw,52px);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;}
.signup-sub{font-size:17px;color:rgba(255,255,255,.7);line-height:1.7;margin-bottom:44px;}
.signup-form{
  background:rgba(255,255,255,.07);backdrop-filter:blur(20px);
  border:1.5px solid rgba(255,255,255,.15);
  border-radius:28px;padding:40px;
  text-align:left;
}
.form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.sf-group{display:flex;flex-direction:column;gap:6px;margin-bottom:14px;}
.sf-label{font-size:12px;font-weight:600;color:rgba(255,255,255,.75);letter-spacing:.04em;}
.sf-input{
  border:1.5px solid rgba(255,255,255,.15);border-radius:12px;
  padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:14px;
  color:#fff;background:rgba(255,255,255,.08);width:100%;
  transition:all .2s;outline:none;
}
.sf-input:focus{border-color:rgba(167,139,250,.6);background:rgba(255,255,255,.12);box-shadow:0 0 0 3px rgba(124,58,237,.2);}
.sf-input::placeholder{color:rgba(255,255,255,.35);}
.sf-select{
  appearance:none;
  background:rgba(255,255,255,.08) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,.5)' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 14px center;
  border:1.5px solid rgba(255,255,255,.15);border-radius:12px;
  padding:13px 40px 13px 16px;font-family:'DM Sans',sans-serif;font-size:14px;
  color:rgba(255,255,255,.8);width:100%;cursor:pointer;
  transition:all .2s;outline:none;
}
.sf-select:focus{border-color:rgba(167,139,250,.6);}
.sf-select option{background:#1E1B4B;color:#fff;}
.sf-role-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:14px;}
.sf-role-btn{
  padding:12px;border-radius:12px;text-align:center;cursor:pointer;
  border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);
  transition:all .2s;
}
.sf-role-btn:hover{border-color:rgba(255,255,255,.3);background:rgba(255,255,255,.1);}
.sf-role-btn.selected{border-color:var(--violet-l);background:rgba(124,58,237,.2);}
.sf-role-ico{font-size:22px;margin-bottom:5px;}
.sf-role-lbl{font-size:11px;font-weight:700;color:rgba(255,255,255,.8);}
.sf-checkbox-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:20px;}
.sf-checkbox{width:18px;height:18px;border-radius:5px;border:1.5px solid rgba(255,255,255,.3);background:transparent;cursor:pointer;flex-shrink:0;margin-top:1px;accent-color:var(--violet);}
.sf-checkbox-lbl{font-size:12px;color:rgba(255,255,255,.6);line-height:1.5;}
.sf-checkbox-lbl a{color:var(--violet-l);text-decoration:underline;cursor:pointer;}
.btn-signup{
  width:100%;padding:16px;border-radius:var(--rp);font-size:15px;font-weight:800;
  color:#fff;background:linear-gradient(135deg,#7C3AED,#0D9488);
  border:none;cursor:pointer;transition:all .3s;
  box-shadow:0 8px 28px rgba(124,58,237,.4);
  display:flex;align-items:center;justify-content:center;gap:10px;
}
.btn-signup:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(124,58,237,.5);}
.btn-signup-arrow{transition:transform .2s;}
.btn-signup:hover .btn-signup-arrow{transform:translateX(6px);}
.signup-login{text-align:center;margin-top:18px;font-size:13px;color:rgba(255,255,255,.5);}
.signup-login a{color:var(--teal-l);font-weight:600;cursor:pointer;}
.signup-trust{display:flex;align-items:center;justify-content:center;gap:20px;margin-top:32px;flex-wrap:wrap;}
.st-item{display:flex;align-items:center;gap:6px;font-size:12px;color:rgba(255,255,255,.5);font-weight:600;}

/* ═══════════════════════════════════════
   FAQ
═══════════════════════════════════════ */
.faq-wrap{padding:90px 5%;max-width:800px;margin:0 auto;}
.faq-list{display:flex;flex-direction:column;gap:12px;margin-top:48px;}
.faq-item{background:#fff;border-radius:16px;border:1.5px solid rgba(0,0,0,.06);overflow:hidden;}
.faq-q{
  display:flex;align-items:center;justify-content:space-between;
  padding:20px 24px;cursor:pointer;font-weight:600;font-size:15px;color:var(--txt);
  transition:background .2s;
}
.faq-q:hover{background:#F9FAFB;}
.faq-q.open{color:var(--violet);}
.faq-icon{font-size:18px;transition:transform .3s;color:var(--muted);}
.faq-q.open .faq-icon{transform:rotate(45deg);color:var(--violet);}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s cubic-bezier(.22,1,.36,1);}
.faq-a.open{max-height:200px;}
.faq-a-inner{padding:0 24px 20px;font-size:14px;color:var(--muted);line-height:1.7;}

/* ═══════════════════════════════════════
   FOOTER
═══════════════════════════════════════ */
.footer{background:#1E1B4B;padding:60px 5% 32px;}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;max-width:1200px;margin:0 auto 48px;}
.footer-logo-text{font-family:'Poppins',sans-serif;font-weight:900;font-size:22px;color:#fff;margin-bottom:12px;}
.footer-about{font-size:13px;color:rgba(255,255,255,.5);line-height:1.7;max-width:260px;margin-bottom:20px;}
.footer-social{display:flex;gap:10px;}
.footer-social-btn{width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:14px;cursor:pointer;transition:all .2s;}
.footer-social-btn:hover{background:rgba(124,58,237,.3);border-color:rgba(124,58,237,.4);}
.footer-col-title{font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:#fff;margin-bottom:16px;letter-spacing:.04em;text-transform:uppercase;}
.footer-link{display:block;font-size:13px;color:rgba(255,255,255,.45);margin-bottom:10px;cursor:pointer;transition:color .2s;}
.footer-link:hover{color:var(--violet-l);}
.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;max-width:1200px;margin:0 auto;font-size:12px;color:rgba(255,255,255,.3);}
.footer-badges{display:flex;gap:10px;}
.footer-badge{padding:4px 12px;border-radius:99px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);font-size:11px;font-weight:700;color:rgba(255,255,255,.4);}

/* Toast */
.toast{position:fixed;bottom:24px;right:24px;z-index:9999;background:#1E1B4B;color:#fff;padding:14px 20px;border-radius:14px;font-size:13px;font-weight:600;box-shadow:0 8px 30px rgba(30,27,75,.3);transform:translateY(80px);opacity:0;transition:all .3s cubic-bezier(.22,1,.36,1);max-width:300px;}
.toast.show{transform:translateY(0);opacity:1;}

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media(max-width:1100px){
  .courses-scroll{grid-template-columns:repeat(2,1fr);}
  .pricing-grid{grid-template-columns:1fr 1fr;}
}
@media(max-width:900px){
  .hero-grid{grid-template-columns:1fr;text-align:center;}
  .hero-right{max-width:360px;margin-top:20px;}
  .hero-cards-grid{position:static;height:auto;display:grid;grid-template-columns:1fr;gap:14px;}
  .hero-mockup-main,
  .hero-card-float{
    position:static;
    top:auto;right:auto;bottom:auto;left:auto;
    transform:none;
    width:100%;
    animation:fadeUp .5s ease both;
  }
  .hero-cta-row{justify-content:center;}.hero-trust{justify-content:center;}
  .personas-grid{grid-template-columns:1fr;}
  .features-grid{grid-template-columns:repeat(2,1fr);}
  .testi-grid{grid-template-columns:1fr 1fr;}
  .stats-band-inner{grid-template-columns:repeat(2,1fr);}
  .footer-grid{grid-template-columns:1fr 1fr;}
  .nav-links{display:none;}
  .nav-mobile-btn{display:block;}
}
@media(max-width:640px){
  .features-grid{grid-template-columns:1fr;}
  .testi-grid{grid-template-columns:1fr;}
  .courses-scroll{grid-template-columns:1fr;}
  .pricing-grid{grid-template-columns:1fr;}
  .form-row-2{grid-template-columns:1fr;}
  .footer-grid{grid-template-columns:1fr;}
  .stats-band-inner{grid-template-columns:1fr 1fr;}
}
</style>
</head>
<body>

<!-- ══════════ NAV ══════════ -->
<nav class="nav" id="mainNav">
  <div class="nav-logo" onclick="scrollTo(0,0)">
    <div class="nav-logo-icon">🎓</div>
    <span class="nav-logo-text">DesignLMS</span>
  </div>
  <div class="nav-links">
    <a class="nav-link" onclick="scrollToSection('features')">Fonctionnalités</a>
    <a class="nav-link" onclick="scrollToSection('courses')">Cours</a>
    <a class="nav-link" onclick="scrollToSection('pricing')">Tarifs</a>
    <a class="nav-link" onclick="scrollToSection('testimonials')">Témoignages</a>
    <a class="nav-link" onclick="scrollToSection('faq')">FAQ</a>
  </div>
  <div class="nav-actions">
    @auth
      <a class="btn-nav-primary" href="{{ route('dashboard') }}">Dashboard →</a>
    @else
      <a class="btn-nav-ghost" href="{{ route('login') }}">Se connecter</a>
      <a class="btn-nav-primary" href="{{ route('register') }}">Créer un compte</a>
    @endauth
  </div>
  <button class="nav-mobile-btn" onclick="showToast('📱 Menu mobile')">☰</button>
</nav>

<!-- ══════════ HERO ══════════ -->
<section class="hero">
  <div class="hero-bg-blob blob1"></div>
  <div class="hero-bg-blob blob2"></div>
  <div class="hero-bg-blob blob3"></div>
  <div class="hero-grid">
    <div class="hero-left">
      <div class="hero-badge">
        <span class="hero-badge-dot"></span>
        🚀 La plateforme LMS nouvelle génération
      </div>
      <h1 class="hero-title">
        Apprenez.<br>
        Créez.<br>
        <span class="hero-title-grad">Décolez.</span>
      </h1>
      <p class="hero-sub">
        <strong>DesignLMS</strong> réunit étudiants passionnés et formateurs experts dans un écosystème pédagogique complet. Cours en vidéo, quiz, lives, certifications — tout est là.
      </p>
      <div class="hero-cta-row">
        @auth
          <a class="btn-hero-primary" href="{{ route('dashboard') }}">
            ✨ Accéder à mon dashboard
          </a>
        @else
          <a class="btn-hero-primary" href="{{ route('register') }}">
            ✨ Créer mon compte gratuit
          </a>
        @endauth
        <button class="btn-hero-outline" onclick="scrollToSection('courses')">
          ▶ Voir les cours
        </button>
      </div>
      <div class="hero-trust">
        <div class="hero-avatars">
          <div class="hero-av" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)">AM</div>
          <div class="hero-av" style="background:linear-gradient(135deg,#059669,#34D399)">ND</div>
          <div class="hero-av" style="background:linear-gradient(135deg,#0284C7,#38BDF8)">RB</div>
          <div class="hero-av" style="background:linear-gradient(135deg,#D97706,#FCD34D)">KY</div>
          <div class="hero-av" style="background:linear-gradient(135deg,#DB2777,#F472B6)">+</div>
        </div>
        <div>
          <div class="hero-stars">⭐⭐⭐⭐⭐</div>
          <span><strong style="color:var(--txt)">{{ number_format($studentsCount, 0, ',', ' ') }}</strong> apprenants · Note moyenne <strong style="color:var(--txt)">{{ $averageRating }}/5</strong></span>
        </div>
      </div>
    </div>

    <div class="hero-right">
      <div class="hero-cards-grid">
        <!-- Carte principale -->
        <div class="hero-mockup-main">
          <div class="mock-header">
            <div class="mock-av" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)">AM</div>
            <div>
              <div class="mock-title">Amira Mansouri</div>
              <div class="mock-sub">🎓 Étudiante · Niveau 7 · 73 400 XP</div>
            </div>
          </div>
          <div class="mock-prog-label"><span style="font-size:12px;color:var(--muted)">UX/UI Design Avancé</span><strong style="color:#7C3AED;font-size:12px">46%</strong></div>
          <div class="mock-prog-bar"><div class="mock-prog-fill" style="width:46%;transition:width 1.5s ease;"></div></div>
          <div style="font-size:11px;color:var(--muted);margin-top:5px;">Prochain : Wireframing Avancé · 13 leçons restantes</div>
          <div class="mock-chips">
            <span class="mock-chip" style="background:#EDE9FE;color:#7C3AED">📚 4 cours</span>
            <span class="mock-chip" style="background:#D1FAE5;color:#059669">🏆 2 certifs</span>
            <span class="mock-chip" style="background:#FEF3C7;color:#D97706">🥇 5 badges</span>
          </div>
        </div>

        <!-- Carte Live -->
        <div class="hero-card-float hcf1">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
            <span style="font-size:20px;">🔴</span>
            <div>
              <div style="font-size:12px;font-weight:700;color:var(--txt)">Live en cours</div>
              <div style="font-size:10px;color:var(--muted)">UX/UI — Live Figma</div>
            </div>
          </div>
          <div style="font-size:11px;color:var(--muted);margin-bottom:8px;">👥 42 participants connectés</div>
          <button style="width:100%;padding:7px;border-radius:99px;background:linear-gradient(135deg,#7C3AED,#0D9488);color:#fff;border:none;font-size:11px;font-weight:700;cursor:pointer;" onclick="showToast('🔴 Rejoindre le live !')">Rejoindre →</button>
        </div>

        <!-- Carte Score -->
        <div class="hero-card-float hcf2">
          <div style="text-align:center;">
            <div style="font-size:28px;margin-bottom:4px;">🏆</div>
            <div style="font-family:Poppins,sans-serif;font-size:24px;font-weight:900;color:#7C3AED">94/100</div>
            <div style="font-size:11px;color:var(--muted)">Quiz Wireframing</div>
            <span style="display:inline-block;margin-top:6px;padding:3px 10px;border-radius:99px;background:#D1FAE5;color:#059669;font-size:10px;font-weight:700">✅ Certifié</span>
          </div>
        </div>

        <!-- Carte Formateur -->
        <div class="hero-card-float hcf3">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
            <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#0284C7,#38BDF8);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;">KB</div>
            <div>
              <div style="font-size:11px;font-weight:700;color:var(--txt)">Karim Benzali</div>
              <div style="font-size:9px;color:var(--muted)">Formateur UX/UI</div>
            </div>
          </div>
          <div style="font-size:11px;color:var(--muted)">⭐ 4.9 · 1 240 étudiants</div>
          <div style="font-size:11px;color:#059669;font-weight:600;margin-top:3px;">💰 +1 230€ ce mois</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════ STATS BAND ══════════ -->
<div class="stats-band">
  <div class="stats-band-inner">
    <div class="stat-item reveal">
      <div class="stat-num" id="s1">{{ number_format($studentsCount, 0, ',', ' ') }}</div>
      <div class="stat-lbl">Apprenants actifs</div>
    </div>
    <div class="stat-item reveal">
      <div class="stat-num" id="s2">{{ number_format($coursesCount, 0, ',', ' ') }}</div>
      <div class="stat-lbl">Cours de qualité</div>
    </div>
    <div class="stat-item reveal">
      <div class="stat-num" id="s3">{{ number_format($certificatesCount, 0, ',', ' ') }}</div>
      <div class="stat-lbl">Certificats délivrés</div>
    </div>
    <div class="stat-item reveal">
      <div class="stat-num" id="s4">{{ $averageRating }}★</div>
      <div class="stat-lbl">Note moyenne des cours</div>
    </div>
  </div>
</div>

<!-- ══════════ 3 PERSONAS ══════════ -->
<div id="features" style="padding:90px 5%;max-width:1200px;margin:0 auto;">
  <div class="reveal" style="text-align:center;margin-bottom:0;">
    <div class="section-badge" style="background:#EDE9FE;color:#7C3AED;margin:0 auto 14px;">✨ Un espace pour chacun</div>
    <h2 class="section-title" style="text-align:center;margin-bottom:12px;">Conçu pour vous,<br><span style="background:linear-gradient(135deg,#7C3AED,#0D9488);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">quel que soit votre rôle</span></h2>
    <p class="section-sub" style="margin:0 auto;text-align:center;">Étudiant ou formateur — DesignLMS s'adapte à vos besoins avec un espace dédié, pensé jusqu'au dernier détail.</p>
  </div>

  <div class="personas-grid reveal">
    <!-- ÉTUDIANT -->
    <div class="persona-card student">
      <span class="persona-emoji">🎓</span>
      <div class="persona-title">Étudiant</div>
      <p class="persona-desc">Progresse à ton rythme avec des cours vidéo HD, des quiz interactifs, des sessions live et un système de gamification qui rend l'apprentissage addictif.</p>
      <div class="persona-features">
        <div class="pf-item"><span class="pf-check">✓</span>Tableau de bord personnalisé & XP</div>
        <div class="pf-item"><span class="pf-check">✓</span>Cours vidéo + PDF + quiz intégrés</div>
        <div class="pf-item"><span class="pf-check">✓</span>Sessions live & enregistrements</div>
        <div class="pf-item"><span class="pf-check">✓</span>Badges de progression & certificats</div>
        <div class="pf-item"><span class="pf-check">✓</span>Forum de discussion par cours</div>
        <div class="pf-item"><span class="pf-check">✓</span>Messagerie privée avec formateurs</div>
      </div>
      <button class="persona-cta" onclick="scrollToSection('signup')">Je m'inscris comme étudiant →</button>
    </div>

    <!-- FORMATEUR -->
    <div class="persona-card trainer">
      <span class="persona-emoji" style="animation-delay:.3s">🧑‍🏫</span>
      <div class="persona-title">Formateur</div>
      <p class="persona-desc">Crée et monétise tes formations avec un studio complet : chapitres vidéo, quiz automatiques, lives, suivi en temps réel de tes étudiants.</p>
      <div class="persona-features">
        <div class="pf-item"><span class="pf-check">✓</span>Créateur de cours intuitif (drag & drop)</div>
        <div class="pf-item"><span class="pf-check">✓</span>Upload vidéo MP4, PDF, DOCX</div>
        <div class="pf-item"><span class="pf-check">✓</span>Quiz & devoirs avec correction auto</div>
        <div class="pf-item"><span class="pf-check">✓</span>Suivi avancement de chaque étudiant</div>
        <div class="pf-item"><span class="pf-check">✓</span>Planning lives & séminaires</div>
        <div class="pf-item"><span class="pf-check">✓</span>Tableau de bord revenus & stats</div>
      </div>
      <button class="persona-cta" onclick="scrollToSection('signup')">Devenir formateur →</button>
    </div>

  </div>
</div>

<!-- ══════════ FEATURES GRID ══════════ -->
<div class="features-wrap">
  <div style="max-width:1200px;margin:0 auto;text-align:center;">
    <div class="reveal">
      <div class="section-badge" style="background:#CCFBF1;color:#0D9488;display:inline-flex;margin:0 auto 14px;">🚀 Tout ce dont vous avez besoin</div>
      <h2 class="section-title">Des fonctionnalités<br><span style="background:linear-gradient(135deg,#0D9488,#4F46E5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">pensées pour l'excellence</span></h2>
    </div>
    <div class="features-grid reveal">
      <div class="feat-card" style="--fc1:#7C3AED;--fc2:#A78BFA" onclick="showToast('🎬 Cours vidéo HD')">
        <span class="feat-ico">🎬</span>
        <div class="feat-title">Cours Vidéo HD</div>
        <div class="feat-desc">Lecteur intégré avec reprise automatique, sous-titres, vitesse variable. Upload MP4 avec CDN pour une diffusion rapide.</div>
        <span class="feat-tag" style="background:#EDE9FE;color:#7C3AED">Étudiant & Formateur</span>
      </div>
      <div class="feat-card" style="--fc1:#0D9488;--fc2:#2DD4BF" onclick="showToast('📝 Quiz interactifs')">
        <span class="feat-ico" style="animation-delay:.2s">📝</span>
        <div class="feat-title">Quiz & Examens</div>
        <div class="feat-desc">QCM, vrai/faux, devoirs libres. Correction automatique, minuteur, résultats immédiats et statistiques détaillées.</div>
        <span class="feat-tag" style="background:#CCFBF1;color:#0D9488">Pédagogie avancée</span>
      </div>
      <div class="feat-card" style="--fc1:#4F46E5;--fc2:#818CF8" onclick="showToast('🔴 Sessions live')">
        <span class="feat-ico" style="animation-delay:.4s">🔴</span>
        <div class="feat-title">Sessions Live</div>
        <div class="feat-desc">Cours en direct, chat temps réel, partage d'écran, sondages instantanés et enregistrement automatique des sessions.</div>
        <span class="feat-tag" style="background:#E0E7FF;color:#4F46E5">Interactif</span>
      </div>
      <div class="feat-card" style="--fc1:#DB2777;--fc2:#F472B6" onclick="showToast('🏆 Gamification')">
        <span class="feat-ico" style="animation-delay:.1s">🏆</span>
        <div class="feat-title">Gamification & XP</div>
        <div class="feat-desc">Système de points d'expérience, badges automatiques, niveaux de progression et certificats numériques signés.</div>
        <span class="feat-tag" style="background:#FCE7F3;color:#DB2777">Motivation</span>
      </div>
      <div class="feat-card" style="--fc1:#D97706;--fc2:#FCD34D" onclick="showToast('📊 Analytics')">
        <span class="feat-ico" style="animation-delay:.3s">📊</span>
        <div class="feat-title">Analytics Avancés</div>
        <div class="feat-desc">Tableaux de bord en temps réel, rapports de progression, analyse des revenus, heatmaps d'activité et exports PDF/CSV.</div>
        <span class="feat-tag" style="background:#FEF3C7;color:#D97706">Admin & Formateur</span>
      </div>
      <div class="feat-card" style="--fc1:#059669;--fc2:#34D399" onclick="showToast('💬 Forum & Messages')">
        <span class="feat-ico" style="animation-delay:.5s">💬</span>
        <div class="feat-title">Forum & Messagerie</div>
        <div class="feat-desc">Forum par cours, fils de discussion, messagerie privée formateur-étudiant, notifications temps réel et historique complet.</div>
        <span class="feat-tag" style="background:#D1FAE5;color:#059669">Communauté</span>
      </div>
    </div>
  </div>
</div>

<!-- ══════════ COURS SHOWCASE ══════════ -->
<div class="courses-wrap" id="courses">
  <div class="reveal" style="text-align:center;">
    <div class="section-badge" style="background:#FEF3C7;color:#D97706;display:inline-flex;margin:0 auto 14px;">🔥 Cours populaires</div>
    <h2 class="section-title" style="text-align:center;">Explorez notre catalogue<br><span style="background:linear-gradient(135deg,#D97706,#DB2777);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">de formations premium</span></h2>
  </div>
  <div class="courses-scroll reveal">
    @foreach($courses as $course)
      <div class="course-card" onclick="showToast('📚 {{ addslashes($course['title']) }}')">
        <div class="cc-cover" style="background:{{ $course['cover_gradient'] }}">
          {{ $course['emoji'] }}
          <span class="cc-badge" style="background:{{ $course['badge_color'] }};color:#fff;">{{ $course['badge_text'] }}</span>
        </div>
        <div class="cc-body">
          <div class="cc-cat" style="color:{{ $course['category_color'] }}">{{ strtoupper($course['category']) }}</div>
          <div class="cc-title">{{ $course['title'] }}</div>
          <div class="cc-meta">👨‍🏫 {{ $course['trainer_name'] }} · {{ $course['level'] }}</div>
          <div class="cc-footer">
            <div class="cc-price" @if($course['price'] === 'Gratuit') style="color:{{ $course['category_color'] }}" @endif>{{ $course['price'] }}</div>
            <div class="cc-rating"><span style="color:#F59E0B">⭐</span> {{ $course['rating'] }} <span style="color:#D1D5DB">({{ number_format($course['reviews_count'], 0, ',', ' ') }})</span></div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div style="text-align:center;margin-top:36px;">
    @auth
      @if(auth()->user()->isEtudiant())
        <a href="{{ route('etudiant.catalogue') }}" style="display:inline-flex;padding:14px 36px;border-radius:99px;background:transparent;border:2px solid rgba(124,58,237,.25);color:#7C3AED;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;">Voir tous les cours →</a>
      @else
        <a href="{{ route('dashboard') }}" style="display:inline-flex;padding:14px 36px;border-radius:99px;background:transparent;border:2px solid rgba(124,58,237,.25);color:#7C3AED;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;">Voir le dashboard →</a>
      @endif
    @else
      <a href="{{ route('login') }}" style="display:inline-flex;padding:14px 36px;border-radius:99px;background:transparent;border:2px solid rgba(124,58,237,.25);color:#7C3AED;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;">Se connecter pour voir les cours →</a>
    @endauth
  </div>
</div>

<!-- ══════════ TESTIMONIALS ══════════ -->
<div class="testimonials-wrap" id="testimonials">
  <div style="max-width:1200px;margin:0 auto;text-align:center;">
    <div class="reveal">
      <div class="section-badge" style="background:#D1FAE5;color:#059669;display:inline-flex;margin:0 auto 14px;">💬 Ils nous font confiance</div>
      <h2 class="section-title">Ce qu'ils disent<br><span style="background:linear-gradient(135deg,#059669,#7C3AED);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">de DesignLMS</span></h2>
    </div>
    <div class="testi-grid reveal">
      @foreach($testimonials as $testimonial)
        <div class="testi-card">
          <div class="quote-mark">"</div>
          <div class="testi-stars">{{ str_repeat('⭐', max(1, min(5, (int) $testimonial['stars']))) }}</div>
          <p class="testi-text">"{{ $testimonial['comment'] }}"</p>
          <div class="testi-author">
            <div class="testi-av" style="{{ $testimonial['gradientStyle'] }}">{{ $testimonial['initials'] }}</div>
            <div><div class="testi-name">{{ $testimonial['name'] }}</div><div class="testi-role">{{ $testimonial['role'] }}</div></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<!-- ══════════ PRICING ══════════ -->
<div class="pricing-wrap" id="pricing">
  <div style="max-width:1200px;margin:0 auto;text-align:center;">
    <div class="reveal">
      <div class="section-badge" style="background:#EDE9FE;color:#7C3AED;display:inline-flex;margin:0 auto 14px;">💎 Tarifs simples</div>
      <h2 class="section-title">Commencez <span style="background:linear-gradient(135deg,#7C3AED,#0D9488);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">gratuitement,</span><br>évoluez à votre rythme</h2>
      <p class="section-sub" style="margin:0 auto 0;text-align:center;">Pas de frais cachés. Annulez à tout moment.</p>
    </div>
    <div class="pricing-grid reveal">
      <!-- FREE -->
      <div class="price-card">
        <div class="price-name">Découverte</div>
        <div class="price-val">0€<span>/mois</span></div>
        <div class="price-period">Accès à vie · Aucune CB requise</div>
        <div class="price-features">
          <div class="pf"><span class="pf-ok">✓</span>Accès aux cours gratuits</div>
          <div class="pf"><span class="pf-ok">✓</span>Forum de discussion</div>
          <div class="pf"><span class="pf-ok">✓</span>Quiz basiques</div>
          <div class="pf"><span class="pf-ok">✓</span>Profil étudiant</div>
          <div class="pf"><span class="pf-no">✕</span>Cours premium</div>
          <div class="pf"><span class="pf-no">✕</span>Certificats</div>
          <div class="pf"><span class="pf-no">✕</span>Sessions live</div>
        </div>
        <button class="btn-price btn-price-outline" onclick="scrollToSection('signup')">Commencer gratuitement</button>
      </div>

      <!-- FORMATEUR -->
      <div class="price-card">
        <div class="price-name">Formateur</div>
        <div class="price-val">0€<span>+ commission</span></div>
        <div class="price-period">15% de commission sur vos ventes</div>
        <div class="price-features">
          <div class="pf"><span class="pf-ok">✓</span>Studio de création illimité</div>
          <div class="pf"><span class="pf-ok">✓</span>Upload vidéo HD (illimité)</div>
          <div class="pf"><span class="pf-ok">✓</span>Quiz, devoirs, examens</div>
          <div class="pf"><span class="pf-ok">✓</span>Planning lives & séminaires</div>
          <div class="pf"><span class="pf-ok">✓</span>Analytics & revenus temps réel</div>
          <div class="pf"><span class="pf-ok">✓</span>Page formateur publique</div>
          <div class="pf"><span class="pf-ok">✓</span>Paiement mensuel automatique</div>
        </div>
        <button class="btn-price btn-price-outline" onclick="scrollToSection('signup')">Devenir formateur →</button>
      </div>
    </div>
  </div>
</div>

<!-- ══════════ INSCRIPTION ══════════ -->
<section class="signup-section" id="signup">
  <div class="signup-bg-circle sc1"></div>
  <div class="signup-bg-circle sc2"></div>
  <div class="signup-bg-circle sc3"></div>
  <div class="signup-inner reveal">
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:99px;padding:6px 16px;font-size:12px;font-weight:700;color:rgba(255,255,255,.8);margin-bottom:20px;">
      🎉 Rejoignez {{ number_format($studentsCount, 0, ',', ' ') }} apprenants · Inscription gratuite en 30 secondes
    </div>
    <h2 class="signup-title">Prêt à <span style="background:linear-gradient(135deg,#A78BFA,#2DD4BF);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">transformer</span><br>votre avenir ?</h2>
    <p class="signup-sub">Créez votre compte maintenant et accédez immédiatement aux cours gratuits, au forum et à votre tableau de bord personnalisé.</p>

    <div class="signup-form">
      @auth
        <a class="btn-signup" href="{{ route('dashboard') }}">
          🚀 Ouvrir mon dashboard
          <span class="btn-signup-arrow">→</span>
        </a>
      @else
        <a class="btn-signup" href="{{ route('register') }}">
          ✨ Créer mon compte gratuitement
          <span class="btn-signup-arrow">→</span>
        </a>

        <div class="signup-login">
          Déjà membre ? <a href="{{ route('login') }}">Se connecter →</a>
        </div>
      @endauth
    </div>

    <div class="signup-trust">
      <div class="st-item">🔒 SSL sécurisé</div>
      <div class="st-item">✅ Accès immédiat</div>
      <div class="st-item">🚫 Sans CB requise</div>
      <div class="st-item">📧 Email de confirmation</div>
    </div>
  </div>
</section>

<!-- ══════════ FAQ ══════════ -->
<div class="faq-wrap" id="faq">
  <div class="reveal" style="text-align:center;">
    <div class="section-badge" style="background:#EDE9FE;color:#7C3AED;display:inline-flex;margin:0 auto 14px;">❓ Questions fréquentes</div>
    <h2 class="section-title" style="text-align:center;">Tout ce que vous<br>voulez savoir</h2>
  </div>
  <div class="faq-list reveal">
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Comment fonctionne l'accès aux cours ?</span><span class="faq-icon">+</span></div>
      <div class="faq-a"><div class="faq-a-inner">Après inscription, vous accédez immédiatement aux cours gratuits. Pour les cours premium, il suffit d'un paiement unique ou d'un abonnement mensuel. L'accès est disponible 24h/24 depuis tous vos appareils.</div></div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Comment devenir formateur sur DesignLMS ?</span><span class="faq-icon">+</span></div>
      <div class="faq-a"><div class="faq-a-inner">Créez votre compte, sélectionnez le rôle "Formateur" et soumettez votre profil. Notre équipe valide les candidatures sous 24-48h. Vous pourrez ensuite créer vos cours avec notre studio intuitif et commencer à vendre dès la validation.</div></div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Les certificats sont-ils reconnus ?</span><span class="faq-icon">+</span></div>
      <div class="faq-a"><div class="faq-a-inner">Nos certificats sont signés numériquement avec un QR code de vérification. Ils sont générés en PDF haute qualité avec votre nom, le cours complété et la date. Partageable sur LinkedIn et dans votre CV.</div></div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Y a-t-il un remboursement possible ?</span><span class="faq-icon">+</span></div>
      <div class="faq-a"><div class="faq-a-inner">Oui, nous offrons une garantie satisfait ou remboursé de 14 jours sans question. Si vous n'êtes pas satisfait d'un cours premium, contactez notre support et nous procédons au remboursement immédiatement.</div></div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Puis-je accéder depuis mobile et tablette ?</span><span class="faq-icon">+</span></div>
      <div class="faq-a"><div class="faq-a-inner">Absolument ! DesignLMS est entièrement responsive et fonctionne sur tous les appareils (mobile, tablette, desktop). Compatible Chrome, Firefox, Safari et Edge. Vos progressions sont synchronisées en temps réel.</div></div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Comment fonctionne le paiement des formateurs ?</span><span class="faq-icon">+</span></div>
      <div class="faq-a"><div class="faq-a-inner">Les formateurs reçoivent 85% des revenus générés par leurs cours (15% de commission pour la plateforme). Le paiement est effectué mensuellement par virement, dès que le seuil de 50€ est atteint.</div></div>
    </div>
  </div>
</div>

<!-- ══════════ FOOTER ══════════ -->
<footer class="footer">
  <div class="footer-grid">
    <div>
      <div class="footer-logo-text">🎓 DesignLMS</div>
      <p class="footer-about">La plateforme de formation en ligne nouvelle génération pour les créatifs, les développeurs et tous ceux qui veulent apprendre différemment.</p>
      <div class="footer-social">
        <div class="footer-social-btn" onclick="showToast('🐦 Twitter/X')">𝕏</div>
        <div class="footer-social-btn" onclick="showToast('💼 LinkedIn')">in</div>
        <div class="footer-social-btn" onclick="showToast('📸 Instagram')">◻</div>
        <div class="footer-social-btn" onclick="showToast('🎬 YouTube')">▶</div>
      </div>
    </div>
    <div>
      <div class="footer-col-title">Plateforme</div>
      <a class="footer-link" onclick="showToast('📚 Catalogue')">Catalogue de cours</a>
      <a class="footer-link" onclick="showToast('🧑‍🏫 Formateurs')">Nos formateurs</a>
      <a class="footer-link" onclick="scrollToSection('pricing')">Tarifs</a>
      <a class="footer-link" onclick="showToast('📜 Certifications')">Certifications</a>
      <a class="footer-link" onclick="showToast('🎓 Pour les entreprises')">Entreprises</a>
    </div>
    <div>
      <div class="footer-col-title">Ressources</div>
      <a class="footer-link" onclick="showToast('📖 Blog')">Blog & Actualités</a>
      <a class="footer-link" onclick="showToast('📘 Documentation')">Documentation</a>
      <a class="footer-link" onclick="showToast('❓ Centre d aide')">Centre d'aide</a>
      <a class="footer-link" onclick="showToast('🤝 Partenaires')">Partenaires</a>
      <a class="footer-link" onclick="showToast('📞 Contact')">Nous contacter</a>
    </div>
    <div>
      <div class="footer-col-title">Légal</div>
      <a class="footer-link" onclick="showToast('📄 CGU')">Conditions d'utilisation</a>
      <a class="footer-link" onclick="showToast('🔒 RGPD')">Politique de confidentialité</a>
      <a class="footer-link" onclick="showToast('🍪 Cookies')">Gestion des cookies</a>
      <a class="footer-link" onclick="showToast('📋 Mentions légales')">Mentions légales</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2026 DesignLMS · Tous droits réservés · Fait avec 💜 pour les apprenants</span>
    <div class="footer-badges">
      <span class="footer-badge">🔒 SSL</span>
      <span class="footer-badge">✅ RGPD</span>
      <span class="footer-badge">🏆 Certifié</span>
    </div>
  </div>
</footer>

<!-- TOAST -->
<div class="toast" id="_toast"><span id="_toastMsg"></span></div>

<script>
/* ── Nav scroll ── */
window.addEventListener('scroll',function(){
  document.getElementById('mainNav').classList.toggle('scrolled',window.scrollY>60);
});

/* ── Scroll reveal ── */
var observer = new IntersectionObserver(function(entries){
  entries.forEach(function(e){
    if(e.isIntersecting){
      e.target.classList.add('visible');
      var delay = e.target.dataset.delay||0;
      e.target.style.transitionDelay = delay+'ms';
    }
  });
},{threshold:.12});
document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(function(el,i){
  el.dataset.delay = (i%4)*80;
  observer.observe(el);
});

/* ── Toast ── */
var _tt=null;
function showToast(msg){
  var t=document.getElementById('_toast'),m=document.getElementById('_toastMsg');
  m.textContent=msg; t.classList.add('show');
  if(_tt) clearTimeout(_tt);
  _tt=setTimeout(function(){t.classList.remove('show');},2600);
}

/* ── Scroll to section ── */
function scrollToSection(id){
  var el=document.getElementById(id);
  if(el) el.scrollIntoView({behavior:'smooth',block:'start'});
}

/* ── FAQ toggle ── */
function toggleFaq(el){
  var a=el.nextElementSibling;
  el.classList.toggle('open');
  a.classList.toggle('open');
}

/* ── Animate progress bar in hero mockup ── */
setTimeout(function(){
  var fill=document.querySelector('.mock-prog-fill');
  if(fill) fill.style.width='46%';
},600);
</script>
</body>
</html>
