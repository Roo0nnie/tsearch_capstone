<div class="mb-4">
    <!-- Row 1: Core System Statistics -->
    <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card border border-light-subtle shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs font-semibold text-muted text-uppercase tracking-wider">Total Users</span>
                    <span class="p-2 rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex"><i class="fas fa-users"></i></span>
                </div>
                <h3 class="mb-1 fw-bold text-dark">{{ count($users) }}</h3>
                <span class="text-muted text-[10px]">Registered repository accounts</span>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card border border-light-subtle shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs font-semibold text-muted text-uppercase tracking-wider">Active Users (7d)</span>
                    <span class="p-2 rounded-circle bg-success bg-opacity-10 text-success d-inline-flex"><i class="fas fa-user-check"></i></span>
                </div>
                <h3 class="mb-1 fw-bold text-dark">{{ count($logusers) }}</h3>
                <span class="text-muted text-[10px]">Logged in during past week</span>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card border border-light-subtle shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs font-semibold text-muted text-uppercase tracking-wider">Total Manuscripts</span>
                    <span class="p-2 rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex"><i class="fas fa-file-alt"></i></span>
                </div>
                <h3 class="mb-1 fw-bold text-dark">{{ count($imrads) }}</h3>
                <span class="text-muted text-[10px]">Cataloged research files</span>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card border border-light-subtle shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs font-semibold text-muted text-uppercase tracking-wider">Recently Added (24h)</span>
                    <span class="p-2 rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex"><i class="far fa-check-circle"></i></span>
                </div>
                <h3 class="mb-1 fw-bold text-dark">
                    {{ $imrads->filter(fn($imrad) => $imrad->created_at >= now()->subDay())->count() }}
                </h3>
                <span class="text-muted text-[10px]">New submissions in last 24h</span>
            </div>
        </div>
    </div>

    <!-- Row 2: Ingestion States & Operations -->
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="card border border-light-subtle shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs font-semibold text-muted text-uppercase tracking-wider">Active Faculty & Guests</span>
                    <span class="p-2 rounded-circle bg-info bg-opacity-10 text-info d-inline-flex"><i class="fa-solid fa-users"></i></span>
                </div>
                <h3 class="mb-1 fw-bold text-dark">{{ $users->filter(fn($user) => $user->status === 'Active')->count() }}</h3>
                <span class="text-muted text-[10px]">Accounts currently set to Active status</span>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border border-light-subtle shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs font-semibold text-muted text-uppercase tracking-wider">Published Files</span>
                    <span class="p-2 rounded-circle bg-success bg-opacity-10 text-success d-inline-flex"><i class="fa-solid fa-book-open"></i></span>
                </div>
                <h3 class="mb-1 fw-bold text-dark">{{ $imrads->where('status', 'published')->count() }}</h3>
                <span class="text-muted text-[10px]">Live documents visible in public repository</span>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border border-light-subtle shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs font-semibold text-muted text-uppercase tracking-wider">Archived Files</span>
                    <span class="p-2 rounded-circle bg-secondary bg-opacity-10 text-secondary d-inline-flex"><i class="fa-solid fa-archive"></i></span>
                </div>
                <h3 class="mb-1 fw-bold text-dark">{{ $imrads->where('status', 'archive')->count() }}</h3>
                <span class="text-muted text-[10px]">Saved drafts or institutional backups</span>
            </div>
        </div>
    </div>
</div>

