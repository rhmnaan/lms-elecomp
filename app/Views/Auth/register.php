<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — LMS Elecomp</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue-deep: #0A1628;
            --blue-mid: #0D2656;
            --blue-sky: #03AADE;
            --blue-light: #38C8F5;
            --accent: #00E5C0;
            --gold: #FFB700;
            --white: #FFFFFF;
            --gray-soft: #F0F4FA;
            --gray-muted: #8A9BBF;
            --danger: #FF4D6A;
            --success: #22C55E;
        }

        html,
        body {
            min-height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--blue-deep);
        }

        .bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: radial-gradient(ellipse 80% 60% at 40% 40%, #0D3580 0%, #0A1628 60%);
            overflow: hidden;
        }

        .bg-canvas::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 80% 80%, rgba(3, 170, 222, 0.15) 0%, transparent 50%), radial-gradient(circle at 20% 20%, rgba(0, 229, 192, 0.10) 0%, transparent 45%);
        }

        .grid-lines {
            position: absolute;
            inset: 0;
            opacity: 0.07;
            background-image: linear-gradient(rgba(56, 200, 245, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(56, 200, 245, 1) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 0%, transparent 75%);
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.22;
            animation: floatOrb 12s ease-in-out infinite;
        }

        .orb-1 {
            width: 280px;
            height: 280px;
            background: var(--accent);
            top: -60px;
            left: 8%;
        }

        .orb-2 {
            width: 220px;
            height: 220px;
            background: var(--blue-sky);
            bottom: 12%;
            right: 6%;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 140px;
            height: 140px;
            background: #7C3AED;
            top: 40%;
            left: 2%;
            animation-delay: -9s;
        }

        @keyframes floatOrb {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-28px) scale(1.07);
            }
        }

        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 229, 192, 0.6);
            animation: particleDrift linear infinite;
        }

        @keyframes particleDrift {
            0% {
                transform: translateY(100vh);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-10vh) translateX(30px);
                opacity: 0;
            }
        }

        .page-wrap {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 480px 1fr;
            align-items: stretch;
        }

        .card-wrap {
            padding: 36px 44px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 20px 0 80px rgba(0, 0, 0, 0.25);
            animation: slideInLeft .8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            overflow-y: auto;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .card-inner {
            max-width: 370px;
            margin: 0 auto;
            width: 100%;
            padding: 20px 0;
        }

        .logo-area {
            text-align: center;
            padding: 20px 0;
        }

        .logo-mark {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-image {
            max-width: 300px;
            height: auto;
            width: 100%;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .logo-image {
                max-width: 200px;
            }
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--blue-sky), var(--blue-mid));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(3, 170, 222, 0.35);
        }

        .logo-icon i {
            color: #fff;
            font-size: 18px;
        }

        .logo-name {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: var(--blue-deep);
            letter-spacing: -0.02em;
        }

        .logo-name span {
            color: var(--blue-sky);
        }

        .logo-tagline {
            font-size: 13px;
            color: var(--gray-muted);
        }

        .form-heading {
            margin-bottom: 24px;
        }

        .form-heading h2 {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--blue-deep);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .form-heading p {
            font-size: 13.5px;
            color: var(--gray-muted);
        }

        .field {
            margin-bottom: 16px;
        }

        .field-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #3D4B6B;
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }

        .field-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .field-icon {
            position: absolute;
            left: 13px;
            color: #9BADD0;
            font-size: 13px;
            pointer-events: none;
            transition: color .2s;
        }

        .field-input {
            width: 100%;
            padding: 12px 13px 12px 38px;
            background: #F4F7FC;
            border: 1.5px solid #E2E8F5;
            border-radius: 11px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            color: var(--blue-deep);
            outline: none;
            transition: all .2s;
        }

        .field-input::placeholder {
            color: #B0BDDA;
        }

        .field-input:focus {
            background: #fff;
            border-color: var(--blue-sky);
            box-shadow: 0 0 0 4px rgba(3, 170, 222, 0.1);
        }

        .field-input.valid {
            border-color: var(--success);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        .field-input.error-field {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(255, 77, 106, 0.1);
        }

        .field-wrap:focus-within .field-icon {
            color: var(--blue-sky);
        }

        .field-valid-icon {
            position: absolute;
            right: 12px;
            font-size: 13px;
            color: var(--success);
            opacity: 0;
            transition: opacity .2s;
            pointer-events: none;
        }

        .field-valid-icon.show {
            opacity: 1;
        }

        .toggle-pw {
            position: absolute;
            right: 11px;
            background: none;
            border: none;
            cursor: pointer;
            color: #9BADD0;
            padding: 4px;
            font-size: 13px;
            transition: color .2s;
        }

        .toggle-pw:hover {
            color: var(--blue-mid);
        }

        .pw-strength {
            margin-top: 9px;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height .3s ease, opacity .3s ease;
        }

        .pw-strength.visible {
            max-height: 90px;
            opacity: 1;
        }

        .strength-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 7px;
        }

        .strength-label {
            font-size: 11px;
            color: #9BADD0;
        }

        .strength-text {
            font-size: 11px;
            font-weight: 600;
        }

        .strength-bars {
            display: flex;
            gap: 4px;
            margin-bottom: 8px;
        }

        .sbar {
            flex: 1;
            height: 3px;
            border-radius: 4px;
            background: #E2E8F5;
            transition: background .3s ease;
        }

        .sbar.active-weak {
            background: var(--danger);
        }

        .sbar.active-medium {
            background: var(--gold);
        }

        .sbar.active-strong {
            background: var(--success);
        }

        .strength-rules {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .rule {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #9BADD0;
            transition: color .25s;
        }

        .rule i {
            font-size: 9px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            border: 1.5px solid #D1D9EE;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .25s;
            color: #C5CEDF;
        }

        .rule.pass {
            color: var(--success);
        }

        .rule.pass i {
            background: #DCFCE7;
            border-color: #86EFAC;
            color: #16A34A;
        }

        .rule.fail {
            color: var(--danger);
        }

        .rule.fail i {
            border-color: #FCA5A5;
            color: var(--danger);
        }

        .confirm-hint {
            font-size: 11.5px;
            margin-top: 6px;
            display: none;
            align-items: center;
            gap: 5px;
        }

        .confirm-hint.show {
            display: flex;
        }

        .confirm-hint.match {
            color: var(--success);
        }

        .confirm-hint.no-match {
            color: var(--danger);
        }

        .terms-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
            margin-top: 4px;
        }

        .terms-check {
            width: 17px;
            height: 17px;
            border-radius: 5px;
            border: 1.5px solid #C5D0E8;
            background: #F4F7FC;
            cursor: pointer;
            flex-shrink: 0;
            margin-top: 1px;
            appearance: none;
            -webkit-appearance: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            position: relative;
        }

        .terms-check:checked {
            background: var(--blue-sky);
            border-color: var(--blue-sky);
        }

        .terms-check:checked::after {
            content: '✓';
            color: white;
            font-size: 11px;
            position: absolute;
            font-weight: 700;
        }

        .terms-text {
            font-size: 12.5px;
            color: #6B7A9B;
            line-height: 1.5;
        }

        .terms-text a {
            color: var(--blue-sky);
            text-decoration: none;
        }

        .error-box {
            display: none;
            background: #FFF0F3;
            border: 1px solid #FFCED8;
            border-radius: 10px;
            padding: 10px 13px;
            font-size: 12.5px;
            color: var(--danger);
            margin-bottom: 16px;
            align-items: center;
            gap: 8px;
        }

        .error-box.show {
            display: flex;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--blue-sky) 0%, var(--blue-mid) 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.01em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .25s;
            box-shadow: 0 8px 24px rgba(3, 170, 222, 0.35);
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--accent) 0%, var(--blue-sky) 100%);
            opacity: 0;
            transition: opacity .3s;
        }

        .btn-submit:hover::before {
            opacity: 1;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(3, 170, 222, 0.45);
        }

        .btn-submit:disabled {
            opacity: 0.65;
            transform: none;
            cursor: not-allowed;
        }

        .btn-submit>* {
            position: relative;
            z-index: 1;
        }

        .spinner {
            width: 15px;
            height: 15px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            display: none;
        }

        .spinner.show {
            display: block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .steps-row {
            display: flex;
            align-items: center;
            margin-bottom: 26px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
            cursor: pointer;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #E2E8F5;
            border: 2px solid #D1D9EE;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #9BADD0;
            transition: all .3s;
            z-index: 1;
            font-family: 'Syne', sans-serif;
        }

        .step.active .step-circle {
            background: var(--blue-sky);
            border-color: var(--blue-sky);
            color: #fff;
            box-shadow: 0 4px 12px rgba(3, 170, 222, 0.4);
        }

        .step.done .step-circle {
            background: var(--success);
            border-color: var(--success);
            color: #fff;
        }

        .step-label {
            font-size: 10px;
            font-weight: 600;
            color: #B0BDDA;
            margin-top: 5px;
            text-align: center;
            transition: color .3s;
        }

        .step.active .step-label {
            color: var(--blue-sky);
        }

        .step.done .step-label {
            color: var(--success);
        }

        .step-line {
            flex: 1;
            height: 2px;
            background: #E2E8F5;
            margin-bottom: 20px;
            transition: background .3s;
        }

        .step-line.done {
            background: var(--success);
        }

        .step-line.active {
            background: var(--blue-sky);
        }

        .form-panel {
            display: none;
        }

        .form-panel.active {
            display: block;
            animation: fadeSlide .35s ease;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateX(16px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nav-row {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .btn-back {
            padding: 13px 18px;
            border-radius: 12px;
            background: #F4F7FC;
            border: 1.5px solid #E2E8F5;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #6B7A9B;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
        }

        .btn-back:hover {
            background: #EEF2FA;
            border-color: #C5D0E8;
        }

        .card-footer-note {
            text-align: center;
            font-size: 12.5px;
            color: #B0BDDA;
            line-height: 1.6;
            margin-top: 8px;
        }

        .card-footer-note a {
            color: var(--blue-sky);
            text-decoration: none;
            font-weight: 500;
        }

        .card-footer-note a:hover {
            text-decoration: underline;
        }

        .right-panel {
            padding: 60px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 560px;
            animation: slideInRight .8s cubic-bezier(0.16, 1, 0.3, 1) .1s forwards;
            opacity: 0;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .badge-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 229, 192, 0.12);
            border: 1px solid rgba(0, 229, 192, 0.3);
            border-radius: 100px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 500;
            color: var(--accent);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 28px;
            width: fit-content;
        }

        .badge-top .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.4);
            }
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(34px, 3.5vw, 50px);
            font-weight: 800;
            line-height: 1.07;
            color: var(--white);
            margin-bottom: 18px;
        }

        .hero-title .line-accent {
            display: block;
            background: linear-gradient(90deg, var(--accent), var(--blue-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-sub {
            font-size: 14.5px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.48);
            max-width: 360px;
            margin-bottom: 36px;
        }

        .benefit-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 14px;
            padding: 14px 16px;
            backdrop-filter: blur(4px);
            transition: all .25s;
        }

        .benefit-item:hover {
            background: rgba(3, 170, 222, 0.08);
            border-color: rgba(3, 170, 222, 0.2);
        }

        .benefit-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .benefit-icon.teal {
            background: rgba(0, 229, 192, 0.15);
            color: var(--accent);
        }

        .benefit-icon.blue {
            background: rgba(3, 170, 222, 0.15);
            color: var(--blue-light);
        }

        .benefit-icon.purple {
            background: rgba(124, 58, 237, 0.15);
            color: #A78BFA;
        }

        .benefit-icon.gold {
            background: rgba(255, 183, 0, 0.15);
            color: var(--gold);
        }

        .benefit-text h4 {
            font-family: 'Syne', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 2px;
        }

        .benefit-text p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
            line-height: 1.4;
        }

        @media (max-width: 860px) {
            .page-wrap {
                grid-template-columns: 1fr;
            }

            .right-panel {
                display: none;
            }

            .card-wrap {
                min-height: 100vh;
                padding: 32px 24px;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>

    <div class="bg-canvas">
        <div class="grid-lines"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="particles" id="particles"></div>
    </div>

    <div class="page-wrap">

        <!-- LEFT: Register Card -->
        <div class="card-wrap">
            <div class="card-inner">
                <div class="logo-area">
                    <div class="logo-mark">
                        <img src="logo/image.png" alt="Absys Group - Elecomp LMS" class="logo-image">
                    </div>
                </div>

                <!-- Steps -->
                <div class="steps-row">
                    <div class="step active" id="step-1" onclick="goToStep(1)">
                        <div class="step-circle" id="sc-1">1</div>
                        <span class="step-label">Akun</span>
                    </div>
                    <div class="step-line" id="line-1"></div>
                    <div class="step" id="step-2" onclick="goToStep(2)">
                        <div class="step-circle" id="sc-2">2</div>
                        <span class="step-label">Profil</span>
                    </div>
                    <div class="step-line" id="line-2"></div>
                    <div class="step" id="step-3" onclick="goToStep(3)">
                        <div class="step-circle" id="sc-3">3</div>
                        <span class="step-label">Selesai</span>
                    </div>
                </div>

                <!-- Error box -->
                <div class="error-box" id="error-box">
                    <i class="fas fa-circle-exclamation"></i>
                    <span id="error-msg-text"></span>
                </div>

                <!-- PANEL 1: Informasi Akun -->
                <div class="form-panel active" id="panel-1">
                    <div class="form-heading">
                        <h2>Buat Akun Baru ✨</h2>
                        <p>Langkah 1 dari 2 — Informasi login Anda</p>
                    </div>

                    <div class="field">
                        <label class="field-label" for="email">Alamat Email</label>
                        <div class="field-wrap">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email" id="email" class="field-input" placeholder="nama@elecomp.sch.id" autocomplete="email">
                            <i class="fas fa-check field-valid-icon" id="vi-email"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <div class="field-wrap">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" id="password" class="field-input" placeholder="Buat password kuat" autocomplete="new-password">
                            <button type="button" class="toggle-pw" id="toggle-pw1" tabindex="-1">
                                <i class="fas fa-eye" id="eye1"></i>
                            </button>
                        </div>
                        <div class="pw-strength" id="pw-strength">
                            <div class="strength-header">
                                <span class="strength-label">Kekuatan password</span>
                                <span class="strength-text" id="strength-text" style="color:#9BADD0">—</span>
                            </div>
                            <div class="strength-bars">
                                <div class="sbar" id="sb1"></div>
                                <div class="sbar" id="sb2"></div>
                                <div class="sbar" id="sb3"></div>
                            </div>
                            <div class="strength-rules">
                                <span class="rule" id="rule-len"><i class="fas fa-check"></i> Min. 8 karakter</span>
                                <span class="rule" id="rule-letter"><i class="fas fa-check"></i> Ada huruf</span>
                                <span class="rule" id="rule-num"><i class="fas fa-check"></i> Ada angka</span>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="field-label" for="confirm-pw">Konfirmasi Password</label>
                        <div class="field-wrap">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" id="confirm-pw" class="field-input" placeholder="Ulangi password Anda" autocomplete="new-password">
                            <button type="button" class="toggle-pw" id="toggle-pw2" tabindex="-1">
                                <i class="fas fa-eye" id="eye2"></i>
                            </button>
                        </div>
                        <div class="confirm-hint" id="confirm-hint">
                            <i class="fas fa-circle-xmark"></i>
                            <span id="confirm-hint-text">Password tidak cocok</span>
                        </div>
                    </div>

                    <button class="btn-submit" id="btn-next" onclick="goNext()">
                        <span id="next-label">Lanjut ke Profil</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <div class="card-footer-note">
                        Sudah punya akun? <a href="<?= base_url('/login') ?>">Masuk di sini</a>
                    </div>
                </div>

                <!-- PANEL 2: Informasi Profil -->
                <div class="form-panel" id="panel-2">
                    <div class="form-heading">
                        <h2>Lengkapi Profil 👤</h2>
                        <p>Langkah 2 dari 2 — Informasi diri Anda</p>
                    </div>

                    <div class="field">
                        <label class="field-label" for="nama">Nama Lengkap</label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text" id="nama" class="field-input" placeholder="Budi Santoso" autocomplete="name">
                        </div>
                    </div>

                    <div class="terms-row">
                        <input type="checkbox" id="terms" class="terms-check">
                        <label for="terms" class="terms-text">
                            Saya menyetujui <a href="#">Syarat & Ketentuan</a> serta
                            <a href="#">Kebijakan Privasi</a> LMS Elecomp.
                        </label>
                    </div>

                    <div class="nav-row">
                        <button class="btn-back" onclick="goToStep(1)">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <button class="btn-submit" id="btn-submit" style="margin-bottom:0; flex:1;" onclick="doRegister()">
                            <span id="btn-label">Buat Akun</span>
                            <div class="spinner" id="spinner"></div>
                            <i class="fas fa-check" id="btn-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- PANEL 3: Sukses -->
                <div class="form-panel" id="panel-3">
                    <div style="text-align:center; padding: 20px 0;">
                        <div style="width:72px;height:72px;background:linear-gradient(135deg,var(--accent),var(--blue-sky));border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 12px 30px rgba(3,170,222,0.35);">
                            <i class="fas fa-check" style="font-size:30px;color:#fff;"></i>
                        </div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:24px;font-weight:800;color:var(--blue-deep);margin-bottom:8px;">Pendaftaran Berhasil!</h2>
                        <p style="font-size:14px;color:var(--gray-muted);margin-bottom:24px;line-height:1.6;">
                            Akun Anda telah dibuat. Silakan login ke dashboard.
                        </p>
                        <a href="<?= base_url('/login') ?>">
                            <button class="btn-submit" style="margin-bottom:0;">
                                <i class="fas fa-arrow-right-to-bracket"></i>
                                <span>Masuk ke Dashboard</span>
                            </button>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT: Hero Panel -->
        <div class="right-panel">
            <div class="badge-top"><span class="dot"></span> Bergabung Sekarang</div>
            <h1 class="hero-title">
                Mulai Perjalanan<br>
                <span class="line-accent">Belajarmu Hari Ini</span>
            </h1>
            <p class="hero-sub">Daftar gratis dan akses ratusan materi, kuis interaktif, serta sertifikat digital bersama ribuan siswa Elecomp.</p>
            <div class="benefit-list">
                <div class="benefit-item">
                    <div class="benefit-icon teal"><i class="fas fa-infinity"></i></div>
                    <div class="benefit-text">
                        <h4>Akses Tak Terbatas</h4>
                        <p>Pelajari semua materi kapan saja, di mana saja tanpa batas.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon blue"><i class="fas fa-chart-line"></i></div>
                    <div class="benefit-text">
                        <h4>Pantau Progres Belajar</h4>
                        <p>Dashboard analitik personal untuk melacak setiap kemajuanmu.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon purple"><i class="fas fa-medal"></i></div>
                    <div class="benefit-text">
                        <h4>Sertifikat Digital</h4>
                        <p>Raih sertifikat resmi yang diakui untuk setiap kursus selesai.</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon gold"><i class="fas fa-users"></i></div>
                    <div class="benefit-text">
                        <h4>Komunitas Aktif</h4>
                        <p>Bergabung dengan 2.400+ siswa dan guru dalam forum diskusi.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        (function() {
            const wrap = document.getElementById('particles');
            for (let i = 0; i < 20; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.width = p.style.height = (Math.random() > 0.6 ? 3 : 2) + 'px';
                p.style.animationDuration = (12 + Math.random() * 18) + 's';
                p.style.animationDelay = -(Math.random() * 25) + 's';
                wrap.appendChild(p);
            }
        })();

        // ── Fingerprint — set cookie sebelum register ──
        function generateFingerprint() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            ctx.textBaseline = 'top';
            ctx.font = '14px Arial';
            ctx.fillText('fp', 2, 2);
            return hashStr([
                navigator.userAgent,
                navigator.language,
                screen.colorDepth,
                screen.width + 'x' + screen.height,
                new Date().getTimezoneOffset(),
                !!window.sessionStorage,
                !!window.localStorage,
                canvas.toDataURL(),
            ].join('|||'));
        }

        function hashStr(str) {
            let h = 0;
            for (let i = 0; i < str.length; i++) {
                h = (h << 5) - h + str.charCodeAt(i);
                h = h & h;
            }
            return Math.abs(h).toString(36);
        }

        function setCookieFP(value) {
            const exp = new Date();
            exp.setFullYear(exp.getFullYear() + 1);
            document.cookie = `device_fp=${value}; expires=${exp.toUTCString()}; path=/; SameSite=Strict`;
        }

        function getFP() {
            const m = document.cookie.match(/device_fp=([^;]+)/);
            if (m) return m[1];
            const fp = generateFingerprint();
            setCookieFP(fp);
            return fp;
        }
        getFP(); // set cookie segera saat halaman dimuat

        // ── CSRF Token Helper ──
        function getCsrfToken() {
            const m = document.cookie.match(/csrf_test_name=([^;]+)/);
            return m ? decodeURIComponent(m[1]) : '';
        }

        const $ = id => document.getElementById(id);
        let currentStep = 1;

        function showError(msg) {
            $('error-msg-text').textContent = msg;
            $('error-box').classList.add('show');
            $('error-box').scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        function hideError() {
            $('error-box').classList.remove('show');
        }

        function setLoading(on) {
            $('btn-submit').disabled = on;
            $('spinner').classList.toggle('show', on);
            $('btn-label').textContent = on ? 'Memproses...' : 'Buat Akun';
            $('btn-icon').style.display = on ? 'none' : '';
        }

        function checkPassword(pass) {
            return {
                hasLen: pass.length >= 8,
                hasLetter: /[a-zA-Z]/.test(pass),
                hasNum: /[0-9]/.test(pass)
            };
        }

        function setRule(id, ok) {
            const el = $(id);
            el.classList.toggle('pass', ok);
            el.classList.toggle('fail', !ok);
        }

        function updateStrengthUI(pass) {
            const meter = $('pw-strength');
            if (!pass.length) {
                meter.classList.remove('visible');
                return;
            }
            meter.classList.add('visible');
            const {
                hasLen,
                hasLetter,
                hasNum
            } = checkPassword(pass);
            setRule('rule-len', hasLen);
            setRule('rule-letter', hasLetter);
            setRule('rule-num', hasNum);
            const score = [hasLen, hasLetter, hasNum].filter(Boolean).length;
            const cls = score === 1 ? 'active-weak' : score === 2 ? 'active-medium' : 'active-strong';
            const labels = ['', 'Lemah', 'Sedang', 'Kuat'];
            const colors = ['', 'var(--danger)', 'var(--gold)', 'var(--success)'];
            $('strength-text').textContent = labels[score];
            $('strength-text').style.color = colors[score];
            ['sb1', 'sb2', 'sb3'].forEach((id, i) => {
                const el = $(id);
                el.className = 'sbar';
                if (i < score) el.classList.add(cls);
            });
        }

        $('email').addEventListener('input', function() {
            hideError();
            const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value.trim());
            this.classList.toggle('valid', ok && this.value.length > 0);
            $('vi-email').classList.toggle('show', ok && this.value.length > 0);
        });

        $('password').addEventListener('input', function() {
            hideError();
            updateStrengthUI(this.value);
            checkConfirm();
            const {
                hasLen,
                hasLetter,
                hasNum
            } = checkPassword(this.value);
            this.classList.toggle('valid', hasLen && hasLetter && hasNum);
        });

        $('confirm-pw').addEventListener('input', checkConfirm);

        function checkConfirm() {
            const pw = $('password').value,
                cpw = $('confirm-pw').value;
            const hint = $('confirm-hint'),
                txt = $('confirm-hint-text'),
                ico = hint.querySelector('i');
            if (!cpw.length) {
                hint.classList.remove('show', 'match', 'no-match');
                return;
            }
            hint.classList.add('show');
            if (pw === cpw) {
                hint.classList.add('match');
                hint.classList.remove('no-match');
                ico.className = 'fas fa-circle-check';
                txt.textContent = 'Password cocok';
                $('confirm-pw').classList.add('valid');
                $('confirm-pw').classList.remove('error-field');
            } else {
                hint.classList.add('no-match');
                hint.classList.remove('match');
                ico.className = 'fas fa-circle-xmark';
                txt.textContent = 'Password tidak cocok';
                $('confirm-pw').classList.remove('valid');
                $('confirm-pw').classList.add('error-field');
            }
        }

        $('toggle-pw1').addEventListener('click', () => toggleEye('password', 'eye1'));
        $('toggle-pw2').addEventListener('click', () => toggleEye('confirm-pw', 'eye2'));

        function toggleEye(fieldId, iconId) {
            const f = $(fieldId),
                i = $(iconId);
            f.type = f.type === 'password' ? 'text' : 'password';
            i.classList.toggle('fa-eye');
            i.classList.toggle('fa-eye-slash');
        }

        function goToStep(n) {
            if (n > currentStep) return;
            showStep(n);
        }

        function showStep(n) {
            currentStep = n;
            document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
            $('panel-' + n).classList.add('active');
            hideError();
            for (let i = 1; i <= 3; i++) {
                const sc = $('sc-' + i),
                    st = $('step-' + i);
                sc.innerHTML = i < n ? '<i class="fas fa-check" style="font-size:10px;"></i>' : i;
                st.className = 'step' + (i < n ? ' done' : i === n ? ' active' : '');
            }
            for (let i = 1; i <= 2; i++) {
                $('line-' + i).className = 'step-line' + (i < n ? ' done' : i === n ? ' active' : '');
            }
        }

        function goNext() {
            hideError();
            const email = $('email').value.trim(),
                pass = $('password').value,
                cpass = $('confirm-pw').value;
            if (!email) {
                showError('Alamat email wajib diisi.');
                return;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showError('Format email tidak valid.');
                return;
            }
            if (!pass) {
                showError('Password wajib diisi.');
                return;
            }
            const {
                hasLen,
                hasLetter,
                hasNum
            } = checkPassword(pass);
            $('pw-strength').classList.add('visible');
            if (!hasLen) {
                showError('Password minimal 8 karakter.');
                setRule('rule-len', false);
                return;
            }
            if (!hasLetter) {
                showError('Password harus mengandung minimal 1 huruf.');
                return;
            }
            if (!hasNum) {
                showError('Password harus mengandung minimal 1 angka.');
                return;
            }
            if (!cpass) {
                showError('Konfirmasi password wajib diisi.');
                return;
            }
            if (pass !== cpass) {
                showError('Password dan konfirmasi password tidak cocok.');
                return;
            }
            showStep(2);
        }

        async function doRegister() {
            hideError();
            const nama = $('nama').value.trim();
            if (!nama) {
                showError('Nama lengkap wajib diisi.');
                return;
            }
            if (!$('terms').checked) {
                showError('Anda harus menyetujui syarat & ketentuan terlebih dahulu.');
                return;
            }

            setLoading(true);
            try {
                const form = new FormData();
                form.append('email_users', $('email').value.trim());
                form.append('password_users', $('password').value);
                form.append('nama_users', nama);

                const res = await fetch('<?= base_url("register") ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: form
                });
                const data = await res.json();

                if (data.status === 'successful') {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        showStep(3);
                    }
                } else {
                    showError(data.message || 'Pendaftaran gagal. Silakan coba lagi.');
                }
            } catch {
                showError('Terjadi kesalahan koneksi. Silakan coba lagi.');
            } finally {
                setLoading(false);
            }
        }

        document.addEventListener('keydown', e => {
            if (e.key !== 'Enter') return;
            if (currentStep === 1) goNext();
            else if (currentStep === 2) doRegister();
        });
    </script>
</body>

</html>