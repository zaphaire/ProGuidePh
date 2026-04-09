@extends('layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'Read the ProGuidePh Privacy Policy to understand how we collect, use, and protect your personal information.')

@section('content')

<div style="background:linear-gradient(135deg,var(--primary),#2d5490);color:#fff;padding:3rem 0 2.5rem">
    <div class="container">
        <h1 style="font-family:'Merriweather',serif;font-size:2rem;margin-bottom:.5rem">🔒 Privacy Policy</h1>
        <p style="color:rgba(255,255,255,.75)">Last updated: {{ date('F d, Y') }}</p>
    </div>
</div>

<div class="container section" style="max-width:860px">
    <div style="background:#fff;border-radius:16px;padding:2.5rem;box-shadow:var(--card-shadow);line-height:1.85;color:var(--text)">

        <p style="font-size:1.05rem;color:var(--text-muted);margin-bottom:2rem">
            Welcome to <strong>ProGuidePh</strong> ("<em>we</em>", "<em>our</em>", or "<em>us</em>"). This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website at <strong>proguideph.com</strong>. Please read this policy carefully.
        </p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">1. Information We Collect</h2>
        <p>We may collect information about you in a variety of ways, including:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem"><strong>Personal Data:</strong> When you contact us or leave a comment, we may collect your name and email address.</li>
            <li style="margin-bottom:.5rem"><strong>Usage Data:</strong> We automatically collect information about how you interact with our website, including pages visited, time spent, and browser type.</li>
            <li style="margin-bottom:.5rem"><strong>Cookies:</strong> We use cookies and similar tracking technologies to enhance your experience on our site.</li>
        </ul>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">2. How We Use Your Information</h2>
        <p>We use the information we collect to:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem">Operate, maintain, and improve our website</li>
            <li style="margin-bottom:.5rem">Respond to your comments and inquiries</li>
            <li style="margin-bottom:.5rem">Monitor and analyze usage and trends to improve your experience</li>
            <li style="margin-bottom:.5rem">Display personalized advertisements through Google AdSense</li>
            <li style="margin-bottom:.5rem">Comply with applicable laws and regulations</li>
        </ul>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">3. Google AdSense & Third-Party Advertising</h2>
        <p>
            We use <strong>Google AdSense</strong> to display advertisements on our website. Google AdSense uses cookies to serve ads based on your prior visits to our site or other sites on the internet. Google's use of advertising cookies enables it and its partners to serve ads to you based on your visit to our site.
        </p>
        <p style="margin-top:.75rem">
            You may opt out of personalized advertising by visiting <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener noreferrer" style="color:var(--primary);border-bottom:1px solid var(--accent)">Google Ads Settings</a>. For more information on how Google uses data, please visit <a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener noreferrer" style="color:var(--primary);border-bottom:1px solid var(--accent)">Google's Privacy &amp; Terms</a>.
        </p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">4. Cookies</h2>
        <p>
            Our website uses cookies to improve your browsing experience. Cookies are small text files stored on your device. We use:
        </p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem"><strong>Essential Cookies:</strong> Required for the website to function properly.</li>
            <li style="margin-bottom:.5rem"><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our site (via Google Analytics).</li>
            <li style="margin-bottom:.5rem"><strong>Advertising Cookies:</strong> Used by Google AdSense to display relevant advertisements.</li>
        </ul>
        <p>You can control cookie settings through your browser's preferences. Disabling cookies may affect certain features of our site.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">5. Data Sharing & Disclosure</h2>
        <p>We do not sell, trade, or rent your personal information to third parties. We may share your information with:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem">Service providers who assist in operating our website (e.g., hosting, analytics)</li>
            <li style="margin-bottom:.5rem">Third-party advertising partners (e.g., Google AdSense)</li>
            <li style="margin-bottom:.5rem">Law enforcement or government agencies when required by law</li>
        </ul>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">6. Data Retention</h2>
        <p>We retain your personal information only as long as necessary to fulfill the purposes outlined in this policy or as required by law. Comments submitted on articles are retained until you request removal.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">7. Your Rights</h2>
        <p>Depending on your location, you may have the right to:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem">Access the personal data we hold about you</li>
            <li style="margin-bottom:.5rem">Request correction or deletion of your data</li>
            <li style="margin-bottom:.5rem">Object to or restrict our processing of your data</li>
            <li style="margin-bottom:.5rem">Withdraw your consent at any time</li>
        </ul>
        <p>To exercise these rights, please contact us at <a href="mailto:support@proguideph.com" style="color:var(--primary)">support@proguideph.com</a>.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">8. Children's Privacy</h2>
        <p>Our website is designed for general audiences and does not knowingly collect personal information from children under 13 years of age. If we become aware that a child under 13 has provided us with personal information, we will delete it immediately.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">9. Changes to This Policy</h2>
        <p>We reserve the right to update this Privacy Policy at any time. Changes will be posted on this page with an updated date. We encourage you to review this page periodically.</p>

        <h2 style="font-family:'Merriweather',serif;color:var(--primary);font-size:1.3rem;margin:2rem 0 .75rem">10. Contact Us</h2>
        <p>If you have any questions about this Privacy Policy, please contact us:</p>
        <ul style="margin:1rem 0 1rem 1.5rem">
            <li style="margin-bottom:.5rem">📧 Email: <a href="mailto:support@proguideph.com" style="color:var(--primary)">support@proguideph.com</a></li>
            <li style="margin-bottom:.5rem">🌐 Website: <a href="{{ route('contact') }}" style="color:var(--primary)">Contact Page</a></li>
        </ul>

    </div>
</div>

@endsection
