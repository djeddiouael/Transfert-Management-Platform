<h1 style="text-align: center; margin-bottom: 20px;">{{ __('faculte.title') }}</h1>

<div class="card-layout">
    <div class="card">
        <img src="/images/faculty1.png" >
    </div>
    <div class="card">
        <img src="/images/faculty2.png" >
    </div>
    <div class="card">
        <img src="/images/faculty3.png" >
    </div>
    <div class="card">
        <img src="/images/faculty4.png" >
    </div>
    <div class="card">
        <img src="/images/faculty5.png" >
    </div>
    <div class="card">
        <img src="/images/faculty6.png" >
    </div>
    <div class="card">
        <img src="/images/faculty7.png" >
    </div>
</div>


<style>
    .card-layout {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        width: 200px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card img {
        max-width: 100%;
        border-radius: 8px;
    }
    .card h3 {
        margin-top: 10px;
        font-size: 18px;
    }
</style>