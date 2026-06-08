<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Situs Sedang Diperbarui</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        />

        <style>
            @import url("https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700&display=swap");

            body {
                font-family: "Outfit", sans-serif;
                background-color: #f8fafc; /* Warna background sangat terang & bersih */
            }

            /* Dekorasi Lingkaran Abstrak */
            .shape {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                z-index: -1;
                opacity: 0.4;
            }

            .shape-1 {
                width: 400px;
                height: 400px;
                background: #3b82f6;
                top: -100px;
                right: -100px;
            }
            .shape-2 {
                width: 300px;
                height: 300px;
                background: #8b5cf6;
                bottom: -50px;
                left: -50px;
            }

            /* Animasi Mengambang untuk Ikon */
            .float {
                animation: floating 3s ease-in-out infinite;
            }

            @keyframes floating {
                0% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-20px);
                }
                100% {
                    transform: translateY(0px);
                }
            }
        </style>
    </head>
    <body class="min-h-screen flex items-center justify-center overflow-hidden">
        <div class="shape shape-1 animate__animated animate__fadeIn"></div>
        <div class="shape shape-2 animate__animated animate__fadeIn"></div>

        <div class="max-w-xl w-full px-6 text-center">
            <div class="mb-10 flex justify-center">
                <div
                    class="float w-32 h-32 bg-white rounded-3xl shadow-xl flex items-center justify-center text-5xl border border-slate-100"
                >
                    <i class="fas fa-tools text-blue-500"></i>
                </div>
            </div>

            <div class="animate__animated animate__fadeInUp">
                <h1
                    class="text-4xl md:text-5xl font-bold text-slate-800 mb-6 tracking-tight"
                >
                    Sedang Kami
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600"
                        >Poles</span
                    >
                </h1>

                <p
                    class="text-slate-500 text-lg md:text-xl leading-relaxed mb-10"
                >
                    Halo! Kami sedang melakukan pemeliharaan rutin untuk
                    memberikan fitur terbaru dan performa yang lebih kencang.
                    Kami akan segera kembali secepatnya.
                </p>

                <div
                    class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-600 font-semibold text-sm mb-12"
                >
                    <span class="relative flex h-3 w-3 mr-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"
                        ></span>
                        <span
                            class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"
                        ></span>
                    </span>
                    Proses Pengembangan: Sedang Berjalan
                </div>
                
               <!-- Tombol LMS -->
<div class="mb-10">
    <a href="/lms" class="inline-flex items-center gap-3 text-white font-semibold text-base px-8 py-4 rounded-2xl"
       style="background: linear-gradient(135deg, #3b82f6, #4f46e5);">
        <i class="fas fa-graduation-cap text-lg"></i>
        Akses LMS Sekarang
        <i class="fas fa-arrow-right text-sm"></i>
    </a>
    <p class="text-slate-400 text-sm mt-3">LMS tetap dapat diakses seperti biasa</p>
</div>

                <div class="flex justify-center gap-8">
                    <a
                        href="#"
                        class="group flex items-center gap-2 text-slate-400 hover:text-blue-600 transition-all"
                    >
                        <i class="fab fa-instagram text-xl"></i>
                        <span class="hidden md:block font-medium"
                            >Instagram</span
                        >
                    </a>
                    <a
                        href="#"
                        class="group flex items-center gap-2 text-slate-400 hover:text-blue-600 transition-all"
                    >
                        <i class="fab fa-twitter text-xl"></i>
                        <span class="hidden md:block font-medium">Twitter</span>
                    </a>
                    <a
                        href="mailto:halo@situsmu.com"
                        class="group flex items-center gap-2 text-slate-400 hover:text-blue-600 transition-all"
                    >
                        <i class="fas fa-envelope text-xl"></i>
                        <span class="hidden md:block font-medium">Email</span>
                    </a>
                </div>
            </div>

            <footer
                class="mt-20 text-slate-400 text-sm animate__animated animate__fadeIn animate__delay-1s"
            >
                &copy; 2026 Absys.id. Semua hak dilindungi.
            </footer>
        </div>
    </body>
</html>
