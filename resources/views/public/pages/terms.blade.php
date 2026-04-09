@extends('layouts.app')

@section('title', 'Terms of Service')
@section('meta_description', 'Read the ProGuidePh Terms of Service to understand the rules and guidelines for using our platform.')

@section('content')

<div style="background:linear-gradient(135deg,var(--primary),#2d5490);color:#fff;padding:3rem 0 2.5rem">
    <div class="container">
        <h1 style="font-family:'Merriweather',serif;font-size:2rem;margin-bottom:.5rem">📋 Terms of Service</h1>
        <p style="color:rgba(255,255,255,.75)">Last updated: {{ date('F d, Y') }}</p>
    </div>
</div>

<div class="container section" style="max-width:860px">
    <div style="background:#fff;border-radius:16px;padding:2.5rem;box-shadow:var(--card-shadow);line-height:1.85;color:var(--text)">

        <p style="font-size:1.05rem;color:var(--text-muted);margin-bottom:2rem">
            By accessing and using <strong>ProGuidePh</strong> (<em>proguideph.com</em>), you agree to be bound by these Terms of Service. Please read them carefully before using our website.
        </p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">1. Acceptance of Terms</h2>
        <p>By accessing or using ProGuidePh, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service and our <a href="{{ route('privacy-policy') }}" style="color:var(--primary);border-bottom:1px solid var(--accent)">Privacy Policy</a>. If you do not agree, please discontinue use of our website.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">2. Use of the Website</h2>
        <p>You agree to use ProGuidePh only for lawful purposes and in accordance with these Terms. You must not:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem">Use the site in any way that violates applicable local, national, or international laws or regulations</li>
            <li style="margin-bottom:.5rem">Post or transmit any material that is defamatory, offensive, or otherwise objectionable</li>
            <li style="margin-bottom:.5rem">Attempt to gain unauthorized access to any part of the website</li>
            <li style="margin-bottom:.5rem">Reproduce, duplicate, or copy our content without written permission</li>
            <li style="margin-bottom:.5rem">Use automated tools to scrape or harvest content from the site</li>
        </ul>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">3. Intellectual Property</h2>
        <p>All content published on ProGuidePh — including articles, images, logos, and design elements — is the property of ProGuidePh or its content contributors and is protected by applicable copyright and intellectual property laws. You may not reproduce, distribute, or create derivative works without explicit written permission.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">4. User-Submitted Content</h2>
        <p>By submitting comments or other content to our website, you grant ProGuidePh a non-exclusive, royalty-free, perpetual license to use, display, and distribute your submission. You are solely responsible for the content you submit and agree that it:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem">Does not infringe on any third-party rights</li>
            <li style="margin-bottom:.5rem">Is not spam, false, misleading, or defamatory</li>
            <li style="margin-bottom:.5rem">Does not contain malicious code or links</li>
        </ul>
        <p>We reserve the right to remove any user-submitted content at our discretion.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">5. Advertising</h2>
        <p>ProGuidePh displays advertisements through <strong>Google AdSense</strong> and may partner with other third-party advertising networks. These ads help us keep our content free and accessible. We are not responsible for the content of external advertisements displayed on our site. Clicking on advertisements is done at your own risk.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">6. Disclaimer of Warranties</h2>
        <p>ProGuidePh is provided on an "<strong>as is</strong>" and "<strong>as available</strong>" basis. We make no warranties, expressed or implied, regarding the accuracy, reliability, or completeness of any information on the site. Our content is intended for general informational purposes only and should not replace professional advice.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">7. Limitation of Liability</h2>
        <p>To the fullest extent permitted by law, ProGuidePh and its team shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of, or inability to use, our website or its content.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">8. External Links</h2>
        <p>Our website may contain links to third-party websites. These links are provided for your convenience only. We have no control over the content of those sites and accept no responsibility for them or for any loss or damage that may arise from your use of them.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">9. Privacy</h2>
        <p>Your use of ProGuidePh is also governed by our <a href="{{ route('privacy-policy') }}" style="color:var(--primary);border-bottom:1px solid var(--accent)">Privacy Policy</a>, which is incorporated into these Terms by this reference.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">10. Changes to Terms</h2>
        <p>We reserve the right to modify these Terms of Service at any time. Changes will be effective immediately upon posting. Your continued use of the website after any changes constitutes your acceptance of the new Terms.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">11. Governing Law</h2>
        <p>These Terms shall be governed by and construed in accordance with the laws of the <strong>Republic of the Philippines</strong>. Any disputes arising in connection with these Terms shall be subject to the exclusive jurisdiction of Philippine courts.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">12. Contact Us</h2>
        <p>If you have any questions about these Terms of Service, please contact us:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem">📧 Email: <a href="mailto:support@proguideph.com" style="color:var(--primary)">support@proguideph.com</a></li>
            <li style="margin-bottom:.5rem">🌐 Website: <a href="{{ route('contact') }}" style="color:var(--primary)">Contact Page</a></li>
        </ul>

    </div>
</div>

@endsection
