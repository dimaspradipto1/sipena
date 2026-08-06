<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- 1. Dashboard -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard.index') ? '' : 'collapsed' }}" href="{{ route('dashboard.index') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- Rekapitulasi & Laporan (Superadmin, Admin BKAK, Kabid, Staff, Pimpinan, Prodi, Dosen Pendamping) -->
    @if(in_array(auth()->user()->role, ['superadmin', 'adminbkak', 'kabid', 'staff', 'pimpinan', 'prodi', 'dosenpendamping']))
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('rekapitulasi.*') ? '' : 'collapsed' }}" href="{{ route('rekapitulasi.index') }}">
        <i class="bi bi-file-earmark-bar-graph"></i>
        <span>Rekapitulasi & Laporan</span>
      </a>
    </li>
    @endif

    <!-- 2. Penyelenggara (Superadmin, Admin BKAK, Kabid, Staff, Pimpinan, Prodi) -->
    @if(in_array(auth()->user()->role, ['superadmin', 'adminbkak', 'kabid', 'staff', 'pimpinan', 'prodi']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kejuaraan.*') ? '' : 'collapsed' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Penyelenggara</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse {{ request()->routeIs('kejuaraan.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('kejuaraan.index') }}" class="{{ request()->routeIs('kejuaraan.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Kejuaraan / Ajang / Lomba</span>
            </a>
          </li>
        </ul>
      </li>
    @endif

    <!-- 3. Prestasi (All Roles) -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('prestasi-belmawa.*', 'prestasi-mandiri.*', 'rekognisi.*', 'sertifikasi.*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-award"></i><span>Prestasi</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse {{ request()->routeIs('prestasi-belmawa.*', 'prestasi-mandiri.*', 'rekognisi.*', 'sertifikasi.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('prestasi-belmawa.index') }}" class="{{ request()->routeIs('prestasi-belmawa.*') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Prestasi Belmawa</span>
          </a>
        </li>
        <li>
          <a href="{{ route('prestasi-mandiri.index') }}" class="{{ request()->routeIs('prestasi-mandiri.*') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Prestasi Mandiri</span>
          </a>
        </li>

        @if(in_array(auth()->user()->role, ['superadmin', 'adminbkak', 'kabid', 'staff', 'pimpinan', 'prodi', 'mahasiswa']))
          <li>
            <a href="{{ route('rekognisi.index') }}" class="{{ request()->routeIs('rekognisi.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Rekognisi</span>
            </a>
          </li>
          <li>
            <a href="{{ route('sertifikasi.index') }}" class="{{ request()->routeIs('sertifikasi.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Sertifikasi</span>
            </a>
          </li>
        @endif
      </ul>
    </li>

    <!-- 4. Tata Kelola (Superadmin, Admin BKAK, Kabid, Staff, Pimpinan) -->
    @if(in_array(auth()->user()->role, ['superadmin', 'adminbkak', 'kabid', 'staff', 'pimpinan']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('institusi.*') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Tata Kelola</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse {{ request()->routeIs('institusi.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('institusi.index') }}" class="{{ request()->routeIs('institusi.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Institusi</span>
            </a>
          </li>
        </ul>
      </li>
    @endif

    <!-- 5. Manajemen Pengguna (Superadmin & Admin BKAK) -->
    @if(in_array(auth()->user()->role, ['superadmin', 'adminbkak']))
      <li class="nav-heading">Pengaturan</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.*') ? '' : 'collapsed' }}" href="{{ route('users.index') }}">
          <i class="bi bi-people"></i>
          <span>Manajemen Pengguna</span>
        </a>
      </li>
    @endif

  </ul>

</aside><!-- End Sidebar-->
