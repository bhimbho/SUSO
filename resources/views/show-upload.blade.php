@extends('layouts.layout')

@section('content')
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Analysis Results</h2>

        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('upload.index') }}">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Uploads</span></li>
                <li><span>Analysis</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>

                    <h2 class="card-title">Performance Analysis</h2>
                </header>
                <div class="card-body">
                    @if(isset($analysis['overall']))
                    <div class="row">
                        @if(isset($analysis['overall']['clicks']))
                        <div class="col-lg-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Clicks</h5>
                                    <h2 class="mb-0">{{ number_format($analysis['overall']['clicks']) }}</h2>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(isset($analysis['overall']['change_from_last_month']))
                        <div class="col-lg-4">
                            <div class="card {{ $analysis['overall']['change_from_last_month'] >= 0 ? 'bg-success' : 'bg-danger' }} text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Change from Last Month</h5>
                                    <h2 class="mb-0">{{ number_format($analysis['overall']['change_from_last_month'], 2) }}%</h2>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if(isset($analysis['monthly_data']))
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Daily Click Performance</h5>
                                    <canvas id="clickChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        @if(isset($analysis['monthly_data']))
        const ctx = document.getElementById('clickChart').getContext('2d');
        
        // Prepare data
        const monthlyData = @json($analysis['monthly_data']);
        const datasets = [];
        
        // Create datasets for each month
        Object.entries(monthlyData).forEach(([month, data], index) => {
            const colors = [
                'rgb(75, 192, 192)',
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(153, 102, 255)'
            ];
            
            datasets.push({
                label: month,
                data: data,
                borderColor: colors[index % colors.length],
                tension: 0.1,
                fill: false
            });
        });
        
        // Create labels based on the longest dataset
        const maxLength = Math.max(...datasets.map(d => d.data.length));
        const labels = Array.from({length: maxLength}, (_, i) => `Day ${i + 1}`);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Click Performance'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Clicks'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                }
            }
        });
        @endif
    });
</script>
@endpush
@endsection