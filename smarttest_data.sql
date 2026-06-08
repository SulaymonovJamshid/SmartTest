-- ============================================================
-- SmartTest — Fanlar va Savollar (225 ta)
-- 2-qadam: Structure SQL dan keyin shu faylni import qiling
-- ============================================================
SET NAMES utf8mb4;
USE `smarttest`;

-- ─── Fanlar ──────────────────────────────────────────────────
INSERT INTO `subjects` (`id`,`name`,`icon`,`description`) VALUES
(1,'Matematika','🔢','Algebra, geometriya va statistika bo\'yicha savollar'),
(2,'Fizika','⚛️','Mexanika, termodinamika va elektromagnitizm bo\'yicha savollar'),
(3,'Informatika','💻','Algoritmlar, ma\'lumotlar tuzilmasi va dasturlash bo\'yicha savollar'),
(4,'Tarix','📜','O\'zbekiston va jahon tarixi bo\'yicha savollar'),
(5,'Biologiya','🧬','Hujayra biologiyasi, genetika va ekologiya bo\'yicha savollar');


-- ============================================================
-- MATEMATIKA (subject_id=1) — 45 ta savol
-- ============================================================
INSERT INTO `questions`
  (`subject_id`,`question_text`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`,`difficulty`)
VALUES
-- Oson (15 ta)
(1,'2 + 2 ning qiymati qancha?','3','4','5','6','b',1),
(1,'10 ni 2 ga bo\'lsak necha bo\'ladi?','4','6','5','8','c',1),
(1,'5 × 6 necha bo\'ladi?','28','30','32','36','b',1),
(1,'100 dan 37 ni ayirsak qancha qoladi?','63','67','73','57','a',1),
(1,'Kvadratning perimetri formulasi?','a²','4a','2a','a+b','b',1),
(1,'81 ning kvadrat ildizi qancha?','7','8','9','10','c',1),
(1,'2 kubga teng son qancha?','6','8','9','12','b',1),
(1,'Doira yuzini hisoblash formulasi?','π×r','2×π×r','π×r²','2×π×r²','c',1),
(1,'Agar x + 5 = 12 bo\'lsa, x = ?','6','7','8','17','b',1),
(1,'25% kasrga o\'tkazilsa?','0.025','0.25','2.5','25','b',1),
(1,'To\'g\'ri burchak necha gradus?','45°','60°','90°','180°','c',1),
(1,'1 km necha metr?','10','100','1000','10000','c',1),
(1,'15 × 3 = ?','42','48','45','40','c',1),
(1,'0.5 ni kasr sifatida ifodalang.','1/4','1/3','1/2','2/3','c',1),
(1,'Teng yonli uchburchakning nechta burchagi teng?','1','2','3','0','c',1),
-- O'rta (15 ta)
(1,'x²-5x+6=0 tenglamasining ildizlari?','x=1,x=6','x=2,x=3','x=-2,x=-3','x=1,x=5','b',2),
(1,'sin(30°) ning qiymati?','√3/2','1/2','√2/2','1','b',2),
(1,'log₂(8) ning qiymati?','2','3','4','8','b',2),
(1,'f(x)=2x+1 bo\'lsa, f(3)=?','5','6','7','8','c',2),
(1,'Uchburchak yuzini hisoblash formulasi?','a×b','(a×b)/2','a+b+c','2(a+b)','b',2),
(1,'2x+3y=12, x=3 bo\'lsa, y=?','1','2','3','4','b',2),
(1,'cos(60°) ning qiymati?','1','√3/2','1/2','0','c',2),
(1,'5! (5 faktorial) qiymati?','60','100','120','150','c',2),
(1,'C(5,2) necha bo\'ladi?','5','8','10','20','c',2),
(1,'∫x dx ning natijasi?','x+C','x²/2+C','2x+C','x²+C','b',2),
(1,'A={1,2,3}, B={2,3,4} bo\'lsa, A∩B=?','{1,2}','{2,3}','{3,4}','{1,2,3,4}','b',2),
(1,'Geometrik progressiya: a₁=2, q=3 bo\'lsa 4-had?','18','27','54','81','c',2),
(1,'Arifmetik progressiya n-had formulasi?','aₙ=a₁+(n-1)d','aₙ=a₁·dⁿ','aₙ=a₁·n','aₙ=a₁-nd','a',2),
(1,'Parabolaning tepasini topish formulasi?','x=b/2a','x=-b/2a','x=b/a','x=-b/a','b',2),
(1,'(AB)ᵀ matritsa xususiyati?','ABᵀ','Bᵀ·Aᵀ','AᵀBᵀ','(Aᵀ)B','b',2),
-- Qiyin (15 ta)
(1,'Euler formulasi e^(iπ)+1=?','2','-1','0','i','c',3),
(1,'Taylor qatorida e^x yoyilmasi?','Σxⁿ/n!','Σ(-1)ⁿxⁿ/n!','Σxⁿ','Σn·xⁿ','a',3),
(1,'Riman gipotezasi nima haqida?','Tub sonlar','Zeta funksiya nollarining joylashuvi','Integrallar','Matritsalar','b',3),
(1,'Stokes teoremasi nimani bog\'laydi?','Chiziqli va sirt integral','Ikki va uch karra integral','Differensial va integral','Matritsa va vektor','a',3),
(1,'Kompleks son z=a+bi uchun |z|=?','a+b','a²+b²','√(a²+b²)','√(a+b)','c',3),
(1,'Galois nazariyasi nimani o\'rganadi?','Differensial tenglamalar','Algebraik tenglamalar va guruhlar','Geometriya','Ehtimollar','b',3),
(1,'Navier-Stokes tenglamalari nimani tavsiflaydi?','Elektromagnit','Suyuqlik harakati','Kvant mexanikasi','Termodinamika','b',3),
(1,'Riemann va Lebesgue integralining asosiy farqi?','Lebesgue kuchliroq','Riemann kuchliroq','Bir xil','Riemann mavjud emas','a',3),
(1,'Leibniz qoidasi d(uv)/dx=?','du/dx·dv/dx','u·dv/dx+v·du/dx','u/v·dv/dx','du/dx+dv/dx','b',3),
(1,'P vs NP muammosi qaysi soha?','Matematika','Informatika nazariyasi','Fizika','Kimyo','b',3),
(1,'Fourier qatorining asosiy sharti?','Uzluksiz bo\'lishi','Dirichlet shartlari','Musbat bo\'lishi','Toq bo\'lishi','b',3),
(1,'Kolmogorov murakkabligi nima?','Minimal tavsiflash ma\'lumoti','Vaqt murakkabligi','Xotira murakkabligi','Tarmoq murakkabligi','a',3),
(1,'Green teoremasi qaysi sohaga tegishli?','Differensial tenglamalar','Vektorli analiz','Ehtimollar','Sonlar nazariyasi','b',3),
(1,'Topologiyada homeomorfizm nima?','Uzluksiz biyeksiya','Ikki tomonlama uzluksiz biyeksiya','Differensiallanuvchi funksiya','Chiziqli aks ettirish','b',3),
(1,'Laplace transformatsiyasi L{f(t)}=?','∫₀^∞ e^(st)f(t)dt','∫₀^∞ e^(-st)f(t)dt','∫₋∞^∞ f(t)dt','∫₀^∞ e^(t)f(t)dt','b',3);


-- ============================================================
-- FIZIKA (subject_id=2) — 45 ta savol
-- ============================================================
INSERT INTO `questions`
  (`subject_id`,`question_text`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`,`difficulty`)
VALUES
-- Oson (15 ta)
(2,'Yorug\'lik tezligi qancha?','3×10⁶ m/s','3×10⁸ m/s','3×10¹⁰ m/s','3×10⁴ m/s','b',1),
(2,'Og\'irlik kuchi formulasi?','F=ma','F=mg','F=mv','F=m/g','b',1),
(2,'1 Newton qanday o\'lchov birligi?','kg·m/s','kg·m/s²','kg/m²','kg·m²/s','b',1),
(2,'Elektr qarshilik o\'lchov birligi?','Amper','Volt','Om','Vatt','c',1),
(2,'Temperatura SI birligi?','Celsius','Fahrenheit','Kelvin','Joule','c',1),
(2,'Arximed qonuni nima haqida?','Elektr','Suyuqlikda suzish','Yorug\'lik','Magnit','b',1),
(2,'Havoda ovoz tezligi taxminan?','340 m/s','3400 m/s','34 m/s','3 m/s','a',1),
(2,'Atom nimadan iborat?','Proton va elektron','Proton, neytron, elektron','Neytron va elektron','Faqat proton','b',1),
(2,'Joule qaysi kattalikni o\'lchaydi?','Kuch','Quvvat','Energiya','Bosim','c',1),
(2,'Nyutonning 1-qonuni qanday nomlanadi?','Dinamika qonuni','Inersiya qonuni','Harakat qonuni','Ta\'sir-javob qonuni','b',1),
(2,'Refraksiya nima?','Yorug\'likning qaytishi','Yorug\'likning sinishi','Yorug\'likning so\'rilishi','Yorug\'likning tarqalishi','b',1),
(2,'Vatt qaysi kattalikni o\'lchaydi?','Energiya','Kuch','Quvvat','Tok','c',1),
(2,'Faradey qonuni qaysi hodisani tavsiflaydi?','Mexanik harakat','Elektromagnit induksiya','Termodinamika','Optika','b',1),
(2,'Mexanik energiya saqlanish qonuni nimani bildiradi?','Energiya yo\'qoladi','Energiya o\'zgarmas qoladi','Energiya ko\'payadi','Energiya soviydi','b',1),
(2,'Radioaktivlikni kim kashf etgan?','Kyuri','Rezerford','Nyuton','Eynshteyn','a',1),
-- O'rta (15 ta)
(2,'Guk qonuni: F=?','F=kx','F=k/x','F=kx²','F=k+x','a',2),
(2,'Kinetik energiya formulasi?','E=mgh','E=½mv²','E=mv','E=mv²','b',2),
(2,'Om qonuni: U=?','U=IR','U=I/R','U=R/I','U=I+R','a',2),
(2,'Doppler effekti nima?','Yorug\'lik tezlashishi','To\'lqin chastotasining o\'zgarishi','Magnit maydoni','Gravitatsiya','b',2),
(2,'Termodinamikaning 1-qonuni?','Entropiya ortadi','ΔU=Q-W','Energiya yo\'qoladi','T=0 bo\'lmaydi','b',2),
(2,'Maxsus nisbiylik nazariyasi muallifi?','Nyuton','Faradey','Eynshteyn','Plank','c',2),
(2,'Fotoeffekt energiya formulasi?','E=hf','E=mc²','E=kT','E=qV','a',2),
(2,'Parallel ulangan kondensatorlar umumiy sig\'imi?','1/C=1/C₁+1/C₂','C=C₁+C₂','C=C₁×C₂','C=C₁-C₂','b',2),
(2,'Yadro reaksiyasida massa-energiya formulasi?','E=mv','E=mc²','E=hf','E=kT','b',2),
(2,'Mayatnik tebranish davri formulasi?','T=2π√(l/g)','T=2πl/g','T=√(l/g)','T=l/g','a',2),
(2,'Snell qonuni nima haqida?','Yorug\'likning qaytishi','Yorug\'likning sinishi','Diffraksiya','Interferensiya','b',2),
(2,'Radioaktiv yarim yemirilish davri nima?','Yadro to\'liq yemiriladi','Massa yarmi yemiriladi','Energiya yarmi chiqadi','Elektron soni kamayadi','b',2),
(2,'Kirxgof qonunlari qayerda qo\'llaniladi?','Mexanikada','Elektr zanjirida','Optikada','Termodinamikada','b',2),
(2,'De Broyl gipotezasi nimani ta\'kidlaydi?','Yorug\'lik zarralardan iborat','Moddiy zarralar to\'lqin xususiyatiga ega','Energiya kvantlanadi','Massa o\'zgaradi','b',2),
(2,'Biol-Savar qonuni nima haqida?','Elektr maydon','Magnit maydon va tok','Gravitatsiya','Termodinamika','b',2),
-- Qiyin (15 ta)
(2,'Shrёdinger tenglamasi nimani tavsiflaydi?','Klassik mexanika','Kvant holatning evolyutsiyasi','Nisbiylik','Termodinamika','b',3),
(2,'Xeyzenberg noaniqlik printsipi: Δx·Δp≥?','ℏ/2','ℏ','2ℏ','ℏ²','a',3),
(2,'QED (Kvant elektrodinamikasi) nima?','Elektron nazariyasi','Foton va elektron o\'zaro ta\'siri nazariyasi','Yadro kuchi','Gravitatsiya kvantlanishi','b',3),
(2,'Kvant mexanikasida spin nima?','Zarrachaning mexanik aylanishi','Ichki burchak momentum','Massa xarakteristikasi','Zaryad','b',3),
(2,'Standart modeldagi fundamental kuchlar soni?','2','3','4','5','c',3),
(2,'QCD nimani o\'rganadi?','Elektromagnit kuch','Kuchli yadro o\'zaro ta\'siri','Gravitatsiya','Zaif o\'zaro ta\'sir','b',3),
(2,'Kosmologik doimiy Lambda nima?','Yorug\'lik tezligi','Koinotning tezlashib kengayishi','Gravitatsiya doimiysi','Plank doimiysi','b',3),
(2,'Bell tengsizligi nimani isbotlaydi?','Kvant mexanikasi noto\'g\'ri','Mahalliy realizm mumkin emas','Klassik fizika to\'g\'ri','Noaniqlik printsipi amal qilmaydi','b',3),
(2,'Hawking nurlanishi nima?','Yulduz nurlanishi','Qora tuynuk atrofida kvant nurlanishi','Yadro sintezi','Radioaktivlik','b',3),
(2,'CPT simmetriyasi nimani anglatadi?','Zarya, paritet, vaqt o\'zgarmasligi','Massa, zarya, spin o\'zgarmasligi','Energiya, zarya, to\'lqin','Kuch, bosim, temperatura','a',3),
(2,'Baryonik assimmetriya muammosi nima?','Nima uchun materiya ko\'p, antimateriya kam','Nima uchun koinot kengayadi','Nima uchun kvarklar uchdir','Nima uchun yorug\'lik egri harakatlanadi','a',3),
(2,'M-nazariya string nazariyalarini qanday birlashtiradi?','11 o\'lchamda','10 o\'lchamda','4 o\'lchamda','26 o\'lchamda','a',3),
(2,'Plank formulasi: qora tana uchun B(ν)=?','hν³/c²','2hν³/c²·1/(e^(hν/kT)-1)','kT/ν','hν/kT','b',3),
(2,'Higgs bozoni qanday ahamiyatga ega?','Gravitatsion massani beradi','Inersial massani beradi','Zarralar massasini ta\'minlovchi maydon kvanti','Elektron massasini beradi','c',3),
(2,'Termodinamikaning 2-qonuni nima haqida?','Energiya saqlanishi','Entropiya doim ortib boradi','Mutlaq nol harorat','Issiqlik kapasiteti','b',3);


-- ============================================================
-- INFORMATIKA (subject_id=3) — 45 ta savol
-- ============================================================
INSERT INTO `questions`
  (`subject_id`,`question_text`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`,`difficulty`)
VALUES
-- Oson (15 ta)
(3,'Binary tizimda 10 soni qanday ifodalanadi?','1010','1001','1100','0110','a',1),
(3,'CPU nima?','Central Processing Unit','Computer Power Unit','Central Power Unit','Computing Process Unit','a',1),
(3,'HTML nima uchun ishlatiladi?','Dasturlash uchun','Veb sahifalar yaratish uchun','Ma\'lumotlar bazasi uchun','Tarmoq uchun','b',1),
(3,'Array (massiv) nima?','Bitta qiymat saqlovchi','Bir xil turdagi elementlar to\'plami','Funksiya turi','Loop turi','b',1),
(3,'RAM nima?','Random Access Memory','Read Access Memory','Rapid Access Memory','Remote Access Memory','a',1),
(3,'Git qanday tizim?','Operatsion tizim','Versiyalarni boshqarish tizimi','Ma\'lumotlar bazasi','Tarmoq protokoli','b',1),
(3,'SQL nima uchun ishlatiladi?','Dasturlash','Ma\'lumotlar bazasini boshqarish','Tarmoq','Dizayn','b',1),
(3,'Loop (sikl) nima?','Bir marta bajariladigan kod','Takrorlanuvchi kod bloki','Shartli operator','Funksiya chaqiruvi','b',1),
(3,'Boolean qiymatlari qanday?','0 va 1','true va false','yes va no','a va b','b',1),
(3,'Stack qanday tamoyilga amal qiladi?','FIFO','LIFO','Random','Priority','b',1),
(3,'IP manzil nima?','Internet Protocol manzili','Internal Protocol manzili','International Protocol manzili','Index Protocol manzili','a',1),
(3,'Rekursiya nima?','O\'zini chaqiruvchi funksiya','Loop turi','Massiv turi','Shart operatori','a',1),
(3,'HTTP 404 kodi nima anglatadi?','Server xatosi','Sahifa topilmadi','Ruxsat yo\'q','Muvaffaqiyatli','b',1),
(3,'Kompilator nima qiladi?','Dasturni bajaradi','Yuqori darajali kodni mashina kodiga o\'giradi','Xatolarni tuzatadi','Kodni formatlaydi','b',1),
(3,'OOP nima?','Ob\'ekt yo\'naltirilgan dasturlash','Ochiq operatsion dasturlash','Optimal operatsion dasturlash','Ob\'ekt onglangan dasturlash','a',1),
-- O'rta (15 ta)
(3,'Bubble sort eng yomon holat murakkabligi?','O(n)','O(n log n)','O(n²)','O(log n)','c',2),
(3,'Binary search uchun asosiy talab?','Array tartibsiz bo\'lishi','Array tartiblangan bo\'lishi','Array bo\'sh bo\'lmasligi','Array katta bo\'lishi','b',2),
(3,'Linked list va array ning asosiy farqi?','Linked list tezroq','Linked list dinamik hajmga ega','Array ko\'proq xotira oladi','Hech qanday farq yo\'q','b',2),
(3,'OOP da encapsulation nima?','Meros olish','Ma\'lumotlarni yashirish va birlashtirish','Polimorfizm','Abstraksiya','b',2),
(3,'REST API da yangi resurs yaratish uchun?','GET','PUT','POST','DELETE','c',2),
(3,'Deadlock nima?','Dastur tezligi','Jarayonlar bir-birini kutib qolishi','Xotira xatosi','Tarmoq xatosi','b',2),
(3,'Hash funksiyaning asosiy xususiyati?','Bir xil input doimo bir xil output','Turli input bir xil output berishi mumkin','Outputdan input tiklash mumkin','Tezlik muhim emas','a',2),
(3,'TCP va UDP ning asosiy farqi?','TCP ishonchli, UDP tezroq','UDP ishonchli, TCP tezroq','Hech qanday farq yo\'q','TCP tezroq, UDP ishonchli','a',2),
(3,'Singleton design pattern nima?','Ko\'p nusxa yaratish','Faqat bitta nusxa mavjud bo\'lishi','Meros olish tartibi','Fayl o\'qish tartibi','b',2),
(3,'Merge sort murakkabligi?','O(n²)','O(n)','O(n log n)','O(log n)','c',2),
(3,'BFS (Breadth First Search) nima?','Chuqurlik bo\'yicha qidirish','Kenglik bo\'yicha qidirish','Eng yaxshisi bo\'yicha qidirish','Binary qidirish','b',2),
(3,'SOLID da S nimani anglatadi?','Security','Single Responsibility Principle','Scalability','Synchronization','b',2),
(3,'ACID da A nimani anglatadi?','Atomicity','Accuracy','Access','Application','a',2),
(3,'WebSocket va HTTP ning asosiy farqi?','WebSocket faqat serverdan','WebSocket ikki tomonlama aloqa','HTTP tezroq','Hech qanday farq yo\'q','b',2),
(3,'Mikrservislar arxitekturasining asosiy afzalligi?','Oddiylik','Mustaqil deploy va masshtablash','Kamroq kod yozish','Tezroq ishlab chiqish','b',2),
-- Qiyin (15 ta)
(3,'CAP teoremasi nimani anglatadi?','Uchtalasi bir vaqtda mumkin emas','Uchtalasi har doim ta\'minlanadi','Faqat ikkitasi kerak','Tarqatilgan tizimlar uchun emas','a',3),
(3,'P vs NP muammosida P sinfi nima?','Polynomial vaqtda hal bo\'ladigan masalalar','Probabilistik masalalar','Parallel masalalar','Primitive masalalar','a',3),
(3,'Byzantine generals muammosi nima haqida?','Tarqatilgan tizimda kelishuv muammosi','Kriptografiya','Tarmoq xatosi','Xotira boshqaruvi','a',3),
(3,'Generational garbage collection nima?','Eski ob\'ektlarni avval tozalash','Yosh ob\'ektlar tez-tez, eski kamroq tekshiriladi','Barcha ob\'ektlar bir vaqtda tozalanadi','Manuel boshqaruv','b',3),
(3,'Consistent Hashing qanday muammoni hal qiladi?','Minimal qayta taqsimlash bilan distributed cache','Xotira xatolarini kamaytirish','Tarmoq tezligini oshirish','Deadlock oldini olish','a',3),
(3,'Event sourcing pattern nima?','Hodisalarni log ga yozish','Holatni hodisalar ketma-ketligi sifatida saqlash','Real-time hodisalar','Async dasturlash','b',3),
(3,'Two-phase commit protokoli nima uchun?','Tarqatilgan tranzaksiyani atomik ta\'minlash','Xotira optimallashtirish','Kriptografiya','Load balancing','a',3),
(3,'Bloom filter nima?','Probabilistik mavjudlik tekshiruvchi tuzilma','Sorting algoritmi','Kriptografik funksiya','Grafni o\'tish algoritmi','a',3),
(3,'Raft konsensus algoritmi nima uchun ishlatiladi?','Lider tanlash va log replikatsiyasi','Kriptografiya','Load balancing','Cache invalidation','a',3),
(3,'JIT (Just-In-Time) kompilyatsiya nima?','Oldindan kompilyatsiya','Bajarish vaqtida kompilyatsiya','Parallel kompilyatsiya','Lazy kompilyatsiya','b',3),
(3,'Homomorphic encryption nima?','Shifrlangan ma\'lumotlar ustida hisoblash','Kalitlarni almashish','Raqamli imzo','Ochiq kalit kriptografiya','a',3),
(3,'Lambda kalkulyatsiyasi funksional dasturlashning asosi?','Ob\'ektlar','Funksiyalar va o\'zgaruvchilar almashinuvi','Sikllar','Pointerlar','b',3),
(3,'Monada nima (funksional dasturlashda)?','Design pattern','Yon ta\'sirlarni boshqaruvchi struktura','Rekursiv funksiya','Tip tizimi','b',3),
(3,'CRDT nima?','Conflict-free Replicated Data Type','Concurrent Replication Data Transfer','Cache Replication Design Tool','Consistency Replication Data Type','a',3),
(3,'Kolmogorov murakkabligi nima haqida?','Ob\'ektni tavsiflash uchun zarur minimal ma\'lumot','Algoritmning vaqt murakkabligi','Xotira murakkabligi','Tarmoq murakkabligi','a',3);


-- ============================================================
-- TARIX (subject_id=4) — 45 ta savol
-- ============================================================
INSERT INTO `questions`
  (`subject_id`,`question_text`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`,`difficulty`)
VALUES
-- Oson (15 ta)
(4,'Amir Temur qachon tug\'ilgan?','1336','1370','1405','1300','a',1),
(4,'O\'zbekiston mustaqilligini qachon qo\'lga kiritdi?','1990','1991','1992','1989','b',1),
(4,'Birinchi Jahon Urushi qachon boshlangan?','1912','1914','1916','1918','b',1),
(4,'Al-Xorazmiy nima uchun mashhur?','Algebra va algoritmlar','Astronomiya','Tibbiyot','Falsafa','a',1),
(4,'Ikkinchi Jahon Urushi qachon tugagan?','1943','1944','1945','1946','c',1),
(4,'AQSH mustaqilligi qachon e\'lon qilingan?','1776','1789','1800','1812','a',1),
(4,'Fransuz inqilobi qachon bo\'lgan?','1776','1789','1800','1815','b',1),
(4,'Ibn Sino qaysi sohada mashhur?','Matematika','Tibbiyot va falsafa','Astronomiya','Kimyo','b',1),
(4,'G\'arbiy Rim imperiyasi qachon qulaган?','376','410','476','500','c',1),
(4,'Chingizxon qaysi davlatni tuzgan?','Xitoy imperiyasi','Mo\'g\'ul imperiyasi','Rus imperiyasi','Fors imperiyasi','b',1),
(4,'Toshkent qachon O\'zbekiston poytaxti bo\'lgan?','1924','1930','1948','1991','a',1),
(4,'Iskandar Zulqarnayn kim bo\'lgan?','Rim imperatori','Makedoniya shohi','Fors shohi','Misr fir\'avni','b',1),
(4,'Buyuk Ipak yo\'lining asosiy ahamiyati?','Harbiy yo\'l','Savdo va madaniy almashinuv yo\'li','Diplomatik yo\'l','Din tarqatish yo\'li','b',1),
(4,'Samarqand qaysi sulolaning poytaxti bo\'lgan?','Somoniylar','Qoraxoniylar','Temuriylar','Shaybaniylar','c',1),
(4,'BMT (Birlashgan Millatlar Tashkiloti) qachon tuzilgan?','1944','1945','1946','1947','b',1),
-- O'rta (15 ta)
(4,'Temuriylar sulolasini kim tugatgan?','1507 yil, Shaybaniy Muhammad','1500 yil, Safaviylar','1510 yil, Baburid','1505 yil, Usmoniylar','a',2),
(4,'O\'rta Osiyo Rossiya tomonidan qachon bosib olingan?','1839-1840','1860-1880','1900-1910','1850-1855','b',2),
(4,'Versailles shartnomasi qachon imzolangan?','1918','1919','1920','1921','b',2),
(4,'Sovet Ittifoqi qachon tuzilgan?','1917','1920','1922','1924','c',2),
(4,'Sovuq urush qachon tugagan?','1989','1990','1991','1992','c',2),
(4,'O\'zbekistonda sovet hokimiyati qachon o\'rnatilgan?','1917','1918','1920','1924','c',2),
(4,'Amir Temurning g\'arbga yurishi qanday natija berdi?','Rum imperiyasini bosib oldi','Boyazid I ni mag\'lub etdi','Vizantiyani oldi','Venetsiyani egalladi','b',2),
(4,'Jadidchilik harakati qanday maqsadda tuzilgan?','Harbiy kuch yaratish','Ta\'lim va jamiyatni isloh qilish','Savdo aloqalarini rivojlantirish','Din tarqatish','b',2),
(4,'Marshall rejasi qanday maqsadda amalga oshirilgan?','Harbiy yordam','Urushdan keyingi Yevropani iqtisodiy tiklash','Kommunizmni tarqatish','Savdo shartnomalari','b',2),
(4,'1917 yil Rossiya inqilobining ikki asosiy bosqichi?','Yanvar va Oktyabr','Fevral va Oktyabr','Mart va Noyabr','Aprel va Dekabr','b',2),
(4,'Xalqlar Ligasi qachon tuzilgan?','1918','1919','1920','1921','c',2),
(4,'Sanoat inqilobi qaysi mamlakatda boshlangan?','Fransiya','Germaniya','Angliya','AQSH','c',2),
(4,'Osiyo va Afrikaning mustamlakachiliksizlanishi asosan qachon?','1930-40-yillar','1940-50-yillar','1950-70-yillar','1970-80-yillar','c',2),
(4,'Yevropa integratsiyasining birinchi shartnomasi?','Rim shartnomasi (1957)','Maastrix shartnomasi','Amsterdam shartnomasi','Parij shartnomasi (1951)','d',2),
(4,'Birinchi jahon urushining asosiy sababi?','Iqtisodiy raqobat','Avstro-Vengriya va Serbiya ziddiyati va ittifoqlar tizimi','Din urushi','Savdo urushi','b',2),
-- Qiyin (15 ta)
(4,'O\'rta asr feodalizmining asosiy iqtisodiy mexanizmi?','Tovar-pul munosabatlari','Yer egaligi va majburiy mehnat','Savdo kapitalizmi','Manufaktura ishlab chiqarish','b',3),
(4,'Qrimea urushining uzoq muddatli oqibati?','Rossiya kuchaydi','Usmoniy imperiya zaiflashdi','Yevropa kuchlar muvozanati o\'zgardi','Barchasi to\'g\'ri','d',3),
(4,'Bismark realpolitikasining mohiyati?','Ideologiyaga asoslangan siyosat','Pragmatik, kuch va manfaatga asoslangan siyosat','Xalqaro huquq ustuvorligi','Demokratiya tarqatish','b',3),
(4,'Annales tarix maktabining metodologiyasi?','Siyosiy tarix','Ijtimoiy va iqtisodiy tarixga e\'tibor','Harbiy tarix','Diplomatik tarix','b',3),
(4,'Post-kolonial nazariya asoschilaridan biri?','Mark Blok','Frantz Fanon','Fernand Brodel','Edward Gibbon','b',3),
(4,'AQSHning Ikkinchi Jahon Urushiga kirishi sababi?','Angliyaga yordam','Pearl-Harbor hujumi','Yevropani ozod qilish','Iqtisodiy manfaat','b',3),
(4,'1924 yil O\'rta Osiyoda chegaralar belgilashning asosiy sababi?','Milliy o\'z-o\'zini boshqarish','Sovet bo\'lib tashlash va boshqarish siyosati','Iqtisodiy maqsadlar','Xalqaro bosim','b',3),
(4,'Toshkentdagi 1966 yilgi zilzilaning siyosiy oqibati?','Hech qanday oqibat bo\'lmadi','SSSR birdamligi va Toshkent qayta qurildi','O\'zbekiston avtonomiyasi kengaydi','Iqtisodiy tanazzul','b',3),
(4,'Jadidchilikning sovet davrida tugatilishining sababi?','O\'z maqsadlariga erishdi','Sovet hokimiyati repressiyasi','Moliyaviy muammolar','Ichki ixtilof','b',3),
(4,'Vestfal tizimi (1648) ning ahamiyati?','Milliy davlat va suverenitet tizimining asosi','Mustamlakalar taqsimi','Yevropa muvozanati','Xalqlar huquqi','a',3),
(4,'Buyuk Ipak yo\'li tanazzulining asosiy sababi?','Dunyo urushi','Dengiz yo\'llari ochilishi va Usmoniylar monopoliyasi','Iqlim o\'zgarishi','Savdo tushishi','b',3),
(4,'Sovet davrida O\'zbekistonda paxta monokulturasining oqibati?','Iqtisodiy rivojlanish','Ekologik inqiroz va Orol dengizining qurishi','Aholining o\'sishi','Sanoatning rivojlanishi','b',3),
(4,'IX-XII asrlarda O\'rta Osiyoda ilm-fan rivojlanishining sababi?','Harbiy zafarlar','Abbosiylar xalifaligi homiyligida ilm rivojlandi','Savdo monopoliyasi','Geografik joylashuv','b',3),
(4,'Erkin savdo nazariyasining tarixiy muxoliflari?','Merkantilistlar','Liberallar','Monetaristlar','Keynschilar','a',3),
(4,'Dekolonizatsiyada "uchlamchi dunyo" tushunchasi qachon paydo bo\'lgan?','1940-yillar','1950-yillar','1960-yillar','1970-yillar','b',3);


-- ============================================================
-- BIOLOGIYA (subject_id=5) — 45 ta savol
-- ============================================================
INSERT INTO `questions`
  (`subject_id`,`question_text`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`,`difficulty`)
VALUES
-- Oson (15 ta)
(5,'Fotosintez qayerda sodir bo\'ladi?','Mitoxondriya','Xloroplast','Yadro','Ribosoma','b',1),
(5,'DNA ning to\'liq nomi?','Deoxyribonucleic Acid','Diribonucleic Acid','Deoxyribonitric Acid','Deribonucleic Acid','a',1),
(5,'Insonning xromosoma soni?','44','46','48','42','b',1),
(5,'Qon qizil rangini nima beradi?','Eritrotsit','Gemoglobin','Leykotsit','Trombosit','b',1),
(5,'Hujayrani boshqaruvchi organoid?','Mitoxondriya','Ribosoma','Yadro','Golji apparati','c',1),
(5,'Evolyutsiya nazariyasini kim kashf etgan?','Mendel','Darvin','Pastyor','Lister','b',1),
(5,'Bakteriyalar qaysi tip organizmlar?','Eukariotlar','Prokariotlar','Viruslar','Zamburug\'lar','b',1),
(5,'O\'pkaning asosiy vazifasi?','Qonni tozalash','Gaz almashinuvi','Oziq-ovqat hazm qilish','Gormonlar ishlab chiqarish','b',1),
(5,'Meioz nima uchun kerak?','O\'sish uchun','Jinsiy hujayralar yaratish uchun','Jarohatlanganlarni almashtirish','Oziq sintez qilish','b',1),
(5,'Qaysi organ insulin ishlab chiqaradi?','Jigar','Buyrak','Me\'da osti bezi','Taloq','c',1),
(5,'ATP nima?','Oqsil turi','Hujayraning energiya valyutasi','Ferment turi','Lipid turi','b',1),
(5,'Qaysi qon guruhi universal donor?','A','B','AB','O','d',1),
(5,'Ekosistemada produsentlar kimlar?','Hayvonlar','O\'simliklar','Zamburug\'lar','Bakteriyalar','b',1),
(5,'Viruslar tirik organizmlarmi?','Ha, to\'liq tirik','Yo\'q, tirik emas','Faqat hujayra ichida tirik','Yarim tirik','c',1),
(5,'Apoptoz nima?','Hujayra bo\'linishi','Dasturlashtirilgan hujayra o\'limi','Hujayra o\'sishi','Hujayra qo\'shilishi','b',1),
-- O'rta (15 ta)
(5,'Mendel qonunlarida dominantlik nima?','Kuchsiz gen ustunligi','Kuchli gen kuchsizni bostirib ko\'rsatishi','Ikki gen bir xil ko\'rinishi','Genlar aralashib ketishi','b',2),
(5,'Transkriptsiya nima?','DNAdan oqsil sintezi','DNAdan mRNA sintezi','mRNAdan oqsil sintezi','DNAning ko\'payishi','b',2),
(5,'Translyatsiya qayerda sodir bo\'ladi?','Yadro','Mitoxondriya','Ribosoma','Golji apparati','c',2),
(5,'Hardy-Vaynberg muvozanati qachon saqlanadi?','Natural tanlanish bo\'lganda','Mutatsiya bo\'lganda','Ideal sharoitda (katta populyatsiya, tasodifiy juftlashish)','Migratsiya bo\'lganda','c',2),
(5,'Qaysi ferment DNAni nusxalaydi?','RNA polimeraz','DNA polimeraz','Ligaz','Restriktsion ferment','b',2),
(5,'Mitoxondriya nima uchun hujayra elektrostansiyasi deyiladi?','Yorug\'lik chiqaradi','ATP ishlab chiqaradi','Isitadi','Elektr toki hosil qiladi','b',2),
(5,'T-limfotsitlar immunitet tizimida qayerda yetiladi?','Suyak ko\'migi','Taloq','Ayrisimon bez (timus)','Limfa tuguni','c',2),
(5,'Fotosintezning yorug\'lik bosqichida nima hosil bo\'ladi?','Glyukoza','CO₂','ATP va NADPH','O\'simlik gormonlari','c',2),
(5,'Populyasiya genetikasida genetic drift nima?','Natural tanlanish','Allel chastotalarining tasodifiy o\'zgarishi','Mutatsiya','Migratsiya','b',2),
(5,'Operon modeli nima haqida?','Oqsil tuzilishi','Prokariot gen regulyatsiyasi','Mitoz bosqichlari','Immunitet jarayoni','b',2),
(5,'Endosimbioz nazariyasi nima haqida?','Evolyutsiya jarayoni','Mitoxondriya va xloroplastlarning kelib chiqishi','Virus kelib chiqishi','Hujayra bo\'linishi','b',2),
(5,'Biom nima?','Bitta organizmning yashash joyi','O\'xshash iqlim va o\'simlikdagi ekosistemalar guruhi','Dengiz ekosistema','Shahar ekologiyasi','b',2),
(5,'Gomeostaz nima?','O\'sish jarayoni','Ichki muhitning barqaror saqlanishi','Oziq-ovqat hazm qilish','Reproduktiv jarayon','b',2),
(5,'Epigenetik nima?','DNAning mutatsiyasi','DNA o\'zgartirmasdan gen ifodasining o\'zgarishi','Yangi gen kiritish','Xromosom kasalligi','b',2),
(5,'Konvergen evolyutsiya qanday misol bilan tushuntiriladi?','It va bo\'ri','Baliq va delfinlarning o\'xshash shakliga ega bo\'lishi','Maymun va inson','Qushlar orasidagi o\'xshashlik','b',2),
-- Qiyin (15 ta)
(5,'CRISPR-Cas9 nima va qanday ishlaydi?','Virus o\'ldiruvchi tizim','DNAni aniq joyida kesib tahrirlash tizimi','Oqsil sintez qiluvchi tizim','Immunitet oshiruvchi tizim','b',3),
(5,'Prionlar nima?','Virus turi','Noto\'g\'ri burmalangan oqsillar — kasallik qo\'zg\'atuvchi','Bakteriya turi','Toxin turi','b',3),
(5,'Telomeraz fermenti nima qiladi?','DNAni ta\'mirlaydi','Telomerlarni uzaytiradi va hujayra qarishini sekinlashtiradi','Mutatsiyani tuzatadi','Gen ifodasini o\'chiradi','b',3),
(5,'Evo-Devo nima?','Turlar evolyutsiyasi','Rivojlanish jarayonlarining evolyutsion o\'zgarishi','Ekologik evolyutsiya','Molekulyar evolyutsiya','b',3),
(5,'Yurak hujayralari nima sababdan regeneratsiya qilmaydi?','Mitoz qobiliyati yo\'q','Hujayra sikli G0 bosqichida to\'xtaydi','Energiyasi yetmaydi','Immunitet to\'sqinlik qiladi','b',3),
(5,'Horizontal gen transferi nima?','Ajdod-avlod orasida gen o\'tishi','Turlar orasida gen o\'tishi (irsiy emas)','Mutatsiya orqali gen o\'zgarishi','Rekombinatsiya','b',3),
(5,'Quorum sensing nima?','Immunitet jarayoni','Bakteriyalarning populyatsiya zichligiga qarab gen ifodasini o\'zgartirishi','Virus ko\'payishi','Hujayra bo\'linishi','b',3),
(5,'Proteom nima?','Genomning bir qismi','Hujayraning barcha oqsillari to\'plami','mRNA to\'plami','Fermentlar to\'plami','b',3),
(5,'Ona mitoxondriyasi faqat onadan meros bo\'lishining sababi?','Ota spermatozoidi mitoxondriyaga ega emas','Urug\'lanishdan so\'ng ota mitoxondriyasi yo\'q qilinadi','Faqat ona gametasida mitoxondriya bor','Ota mitoxondriyasi ishlamaydi','b',3),
(5,'Sintez biologiyasi nima?','Tabiiy biologik tizimlarni o\'rganish','Yangi biologik qismlarni loyihalash va qurish','Organizmlarni klonlash','GMO yaratish','b',3),
(5,'Mikrobiotaning inson sog\'lig\'iga ta\'siri qanday?','Faqat zarar keltiradi','Immunitet, hazm va metabolizmga ijobiy ta\'sir qiladi','Faqat ichaklarda ishlaydi','Ta\'siri yo\'q','b',3),
(5,'P53 geni qanday vazifani bajaradi?','O\'sishni stimulyatsiya qiladi','Saraton bostiruvchi — shikastlangan hujayralarni to\'xtatadi','Oqsil sintez qiladi','Immunitetni boshqaradi','b',3),
(5,'Litik va lizogenik tsikl orasidagi asosiy farq?','Litik virus hujayraga kiradi, lizogenik kiritmaydi','Litik hujayrani yo\'q qiladi, lizogenik DNAni integratsiya qiladi','Ikkalasi bir xil','Lizogenik tezroq','b',3),
(5,'Neyroplastiklik (neuroplasticity) nima?','Miyaning hajmi o\'zgarishi','Miyaning yangi ulanishlar hosil qilish va qayta tuzilish qobiliyati','Nerv hujayralarining regeneratsiyasi','Gormonlar ta\'siri','b',3),
(5,'Epigenetik meros nima?','DNAdagi mutatsiya','Gen ifodasi o\'zgarishlarining avlodlarga o\'tishi','Xromosom soni o\'zgarishi','Mutatsiya tarqalishi','b',3);

