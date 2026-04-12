@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? '')

@section('content')

<div style="background:linear-gradient(135deg,var(--primary-dark) 0%,var(--primary) 50%,var(--primary-light) 100%);background-size:200% 200%;animation:gradientFlow 15s ease infinite;padding:5rem 0 3rem;overflow:hidden;width:100%;max-width:100%;box-sizing:border-box">
    <div class="container">
        <h1 style="font-family:'Poppins',sans-serif;font-size:2.25rem;font-weight:800;color:#fff;text-align:center;margin:0">{{ $page->title }}</h1>
    </div>
</div>

<div class="container" style="padding:2rem 0.5rem;overflow:hidden">
    <div class="about-page-content">
        {!! $page->body !!}
    </div>
</div>

<style>
.about-page-content { 
    overflow-x: hidden; 
    width: 100%; 
    max-width: 100%; 
    box-sizing: border-box; 
}
.about-page-content > div, 
.about-page-content > section, 
.about-page-content > article,
.about-page-content > p,
.about-page-content > ul,
.about-page-content > ol { 
    max-width: 100%; 
    overflow-x: hidden; 
    box-sizing: border-box; 
    margin-bottom: 2rem !important;
    display: block;
    width: 100%;
}
.about-page-content > div:last-child,
.about-page-content > section:last-child,
.about-page-content > article:last-child,
.about-page-content > p:last-child,
.about-page-content > ul:last-child,
.about-page-content > ol:last-child {
    margin-bottom: 0 !important;
}
.about-page-content .about-hero {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--primary) 100%);
    background-size: 200% 200%;
    animation: gradientFlow 15s ease infinite;
    color: #fff;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    isolation: isolate;
    transform: translateZ(0);
    -webkit-transform: translateZ(0);
    display: block;
    width: 100%;
}
.about-page-content .about-hero::before {
    content: '';
    position: absolute;
    top: -40%;
    right: -5%;
    width: 280px;
    height: 280px;
    background: rgba(232,160,32,.12);
    border-radius: 50%;
    pointer-events: none;
}
.about-page-content .about-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 220px;
    height: 220px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
    pointer-events: none;
}
.about-page-content .about-badge {
    display: inline-block;
    background: rgba(232,160,32,.2);
    border: 1px solid rgba(232,160,32,.4);
    color: var(--accent-light);
    padding: .4rem 1rem;
    border-radius: 999px;
    font-family: 'Poppins', sans-serif;
    font-size: .8rem;
    font-weight: 600;
    margin-bottom: 1rem;
}
.about-page-content .about-hero h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    line-height: 1.3;
}
.about-page-content .about-hero p {
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    color: rgba(255,255,255,.9);
    line-height: 1.8;
    margin: 0;
}
.about-page-content .about-section {
    padding: 1.5rem;
    background: var(--bg-white);
    border-radius: 16px;
    border: 1px solid var(--border-light);
    margin-bottom: 2rem !important;
}
.about-page-content .about-section h2 {
    font-family: 'Poppins', sans-serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: .75rem;
}
.about-page-content .about-section h2 .icon {
    font-size: 1.25rem;
}
.about-page-content .about-section > p {
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    color: var(--text-secondary);
    line-height: 1.8;
    margin: 0;
}
.about-page-content .about-mission {
    background: linear-gradient(135deg, rgba(0,56,168,.03), rgba(0,56,168,.06));
    border-color: rgba(0,56,168,.1);
    text-align: center;
    padding: 2.5rem 2rem;
}
.about-page-content .about-mission h2 {
    justify-content: center;
    color: var(--primary);
    font-size: 1.5rem;
}
.about-page-content .about-mission p {
    font-size: 1.15rem;
    color: var(--text);
    max-width: 750px;
    margin: 0 auto;
    line-height: 1.8;
}
.about-page-content .values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-top: 1.25rem;
}
.about-page-content .value-card {
    background: linear-gradient(135deg, #f8fafc, #fff);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem;
    text-align: center;
    transition: all .3s;
}
.about-page-content .value-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-card-hover);
    border-color: var(--accent);
}
.about-page-content .value-icon {
    font-size: 2.5rem;
    margin-bottom: .75rem;
    display: block;
}
.about-page-content .value-card h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: .5rem;
}
.about-page-content .value-card p {
    font-family: 'Inter', sans-serif;
    font-size: .875rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0;
}
.about-page-content .why-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1.25rem;
}
.about-page-content .why-item {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--bg-white);
    border-radius: 12px;
    border: 1px solid var(--border);
    transition: all .3s;
}
.about-page-content .why-item:hover {
    border-color: var(--accent);
    box-shadow: var(--shadow-sm);
}
.about-page-content .why-number {
    width: 36px;
    height: 36px;
    min-width: 36px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: .9rem;
}
.about-page-content .why-item h3 {
    font-family: 'Poppins', sans-serif;
    font-size: .95rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: .25rem;
}
.about-page-content .why-item p {
    font-family: 'Inter', sans-serif;
    font-size: .875rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 768px) {
    .about-page-content > div,
    .about-page-content > section,
    .about-page-content > article,
    .about-page-content > p,
    .about-page-content > ul,
    .about-page-content > ol { 
        margin-bottom: 2rem !important;
    }
    .about-page-content .about-hero { 
        padding: 1.5rem 1rem; 
        margin-top: 2rem;
        display: flex;
        flex-direction: column;
    }
    .about-page-content .about-hero-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .about-page-content .about-hero h1 { font-size: 1.35rem; }
    .about-page-content .about-hero p { font-size: 0.95rem; }
    .about-page-content .values-grid { grid-template-columns: 1fr; gap: 1rem; }
    .about-page-content .about-section { padding: 1.25rem; margin-bottom: 1.5rem; }
    .about-page-content .about-mission { padding: 1.5rem; }
    .about-page-content .about-mission p { font-size: 1rem; }
    .about-page-content .why-item { padding: 1rem; gap: 0.75rem; }
    .about-page-content .why-item + .why-item { margin-top: 0.75rem; }
}
@media (max-width: 480px) {
    .about-page-content > div,
    .about-page-content > section,
    .about-page-content > article { 
        margin-bottom: 1.5rem !important;
    }
    .about-page-content .about-hero { 
        padding: 1.25rem 0.75rem; 
        margin-top: 1.5rem;
    }
    .about-page-content .about-hero h1 { font-size: 1.2rem; }
}
</style>

@endsection
