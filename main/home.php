<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Dashboard";
$tr_type="dashboard";
$page_name="home.php";
?>

<style>
  /* ===================== RESET & BASE ===================== */
  :root {
    --navy: #0B1629;
    --navy2: #122040;
    --navy3: #1a2f55;
    --gold: #C9A84C;
    --gold2: #e8c46a;
    --blue: #1A56A5;
    --blue2: #2563EB;
    --ice: #E8F0FB;
    --parch: #F7F5F0;
    --parch2: #EDE9E1;
    --white: #ffffff;
    --text: #1a1a2e;
    --text2: #4a4a6a;
    --text3: #8890a4;
    --green: #059669;
    --red: #DC2626;
    --orange: #D97706;
    --purple: #7C3AED;
    --radius: 14px;
    --radius-sm: 8px;
    --shadow: 0 4px 24px rgba(11,22,41,0.10);
    --shadow-lg: 0 12px 48px rgba(11,22,41,0.18);
    --transition: all 0.28s cubic-bezier(.4,0,.2,1);
  }

  .dashboard-wrapper {
    background: var(--parch);
    color: var(--text);
    /* padding: 28px 32px; */
    display: flex;
    flex-direction: column;
    gap: 24px;
    /* font-family: sans-serif; */
  }

  /* ===================== STAT CARDS ===================== */
  .stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
  }
  .stat-card {
    background: white;
    border-radius: var(--radius);
    padding: 22px 22px 18px;
    box-shadow: var(--shadow);
    position: relative; overflow: hidden;
    transition: var(--transition);
    border: 1px solid rgba(0,0,0,0.04);
  }
  .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
  .stat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
  }
  .stat-card.blue::before { background: linear-gradient(90deg, var(--blue), var(--blue2)); }
  .stat-card.gold::before { background: linear-gradient(90deg, var(--gold), var(--gold2)); }
  .stat-card.green::before { background: linear-gradient(90deg, var(--green), #34d399); }
  .stat-card.red::before { background: linear-gradient(90deg, var(--red), #f87171); }
  .stat-card.purple::before { background: linear-gradient(90deg, var(--purple), #a78bfa); }
  .stat-card.orange::before { background: linear-gradient(90deg, var(--orange), #fbbf24); }
  .stat-label { font-size: 0.7rem; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px; }
  .stat-value {
    /* font-family: serif; */
    font-size: 2.2rem; font-weight: 700; color: var(--navy); line-height: 1;
    margin-bottom: 8px;
  }
  .stat-sub { font-size: 0.72rem; color: var(--text3); display: flex; align-items: center; gap: 4px; }
  .stat-up { color: var(--green); font-weight: 700; }
  .stat-dn { color: var(--red); font-weight: 700; }
  .stat-icon {
    position: absolute; right: 18px; top: 18px;
    font-size: 1.6rem;
    
    opacity: 0.9;
  }

  /* ===================== CARDS ===================== */
  .custom-card {
    background: white; border-radius: var(--radius);
    box-shadow: var(--shadow); border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
  }
  .custom-card-header {
    padding: 18px 22px; border-bottom: 1px solid var(--parch2);
    display: flex; align-items: center; justify-content: space-between;
  }
  .custom-card-title { font-weight: 700; font-size: 0.9rem; color: var(--navy); }
  .custom-card-body { padding: 20px 22px; }

  /* ===================== PIPELINE BAR ===================== */
  .pipeline-bar { display: flex; border-radius: 6px; overflow: hidden; height: 28px; margin: 10px 0; }
  .pipe-seg {
    display: flex; align-items: center; justify-content: center;
    font-size: 0.64rem; font-weight: 800; color: white;
    transition: var(--transition); cursor: pointer;
  }
  .pipe-seg:hover { filter: brightness(1.15); }

  .unit-legend { display: flex; gap: 14px; flex-wrap: wrap; }
  .legend-item { display: flex; align-items: center; gap: 5px; font-size: 0.7rem; color: var(--text2); font-weight: 600; }
  .legend-dot { width: 10px; height: 10px; border-radius: 50%; }

  /* ===================== DASHBOARD GRID ===================== */
  .dash-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; }

  /* ===================== CHART AREA ===================== */
  .chart-bar {
    flex: 1; border-radius: 4px 4px 0 0;
    background: linear-gradient(to top, var(--blue), var(--blue2));
    opacity: 0.7; transition: var(--transition);
    cursor: pointer; position: relative;
  }
  .chart-bar:hover { opacity: 1; transform: scaleY(1.05); transform-origin: bottom; }
  .chart-bar.gold { background: linear-gradient(to top, var(--gold), var(--gold2)); }

  /* ===================== TIMELINE ===================== */
  .timeline { display: flex; flex-direction: column; gap: 0; }
  .timeline-item { display: flex; gap: 14px; padding: 10px 0; border-bottom: 1px solid var(--parch2); }
  .timeline-item:last-child { border-bottom: none; }
  .tl-dot {
    width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
  }
  .tl-body .tl-title { font-weight: 600; font-size: 0.8rem; color: var(--navy); }
  .tl-body .tl-time { font-size: 0.68rem; color: var(--text3); margin-top: 1px; }

  /* ===================== TABLE ===================== */
  .data-table { width: 100%; border-collapse: collapse; }
  .data-table thead tr { background: var(--parch); }
  .data-table th {
    padding: 10px 14px; text-align: left;
    font-size: 0.67rem; font-weight: 700;
    color: var(--text3); text-transform: uppercase; letter-spacing: 0.1em;
    border-bottom: 1px solid var(--parch2);
    white-space: nowrap;
  }
  .data-table td {
    padding: 13px 14px; font-size: 0.8rem; color: var(--text2);
    border-bottom: 1px solid rgba(0,0,0,0.04);
    vertical-align: middle;
  }
  .td-main { color: var(--text) !important; font-weight: 600; }

  .lead-rep {
    width: 24px; height: 24px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), var(--purple));
    display: flex; align-items: center; justify-content: center;
    font-size: 0.6rem; font-weight: 800; color: white;
  }

  .btn-outline {
    padding: 7px 14px;
    background: transparent; color: var(--text2);
    border: 1px solid var(--parch2); border-radius: 8px;
    font-size: 0.76rem; font-weight: 600; cursor: pointer;
    display: flex; align-items: center; gap: 5px;
    transition: var(--transition);
    /* font-family: sans-serif; */
  }
  .btn-outline:hover { border-color: var(--blue); color: var(--blue); }

  @media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .dash-grid { grid-template-columns: 1fr; }
  }
</style>

<section class="dashboard-wrapper">
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="stat-label">Total Units</div>
        <div class="stat-value">148</div>
        <div class="stat-sub"><span class="stat-up">↑ 8</span> added this month</div>
        <div class="stat-icon">🪟</div>
      </div>
      <div class="stat-card green">
        <div class="stat-label">Revenue Collected</div>
        <div class="stat-value">৳4.2Cr</div>
        <div class="stat-sub"><span class="stat-up">↑ 12%</span> vs last month</div>
        <div class="stat-icon">💰</div>
      </div>
      <div class="stat-card gold">
        <div class="stat-label">Active Leads</div>
        <div class="stat-value">38</div>
        <div class="stat-sub"><span class="stat-up">↑ 5</span> new this week</div>
        <div class="stat-icon">📍</div>
      </div>
      <div class="stat-card purple">
        <div class="stat-label">Units Sold</div>
        <div class="stat-value">47</div>
        <div class="stat-sub"><span class="stat-up">↑ 3</span> this month</div>
        <div class="stat-icon">✅</div>
      </div>
    </div>

    <!-- Unit Status Pipeline -->
    <div class="custom-card">
      <div class="custom-card-header">
        <div>
          <div class="custom-card-title">Unit Inventory Overview</div>
          <div style="font-size:0.7rem;color:var(--text3);margin-top:2px">Across all 3 buildings — 148 total units</div>
        </div>
        <button class="btn-outline">View All Units</button>
      </div>
      <div class="custom-card-body">
        <div class="pipeline-bar">
          <div class="pipe-seg" style="width:34%;background:#059669" title="Available">34% Available</div>
          <div class="pipe-seg" style="width:22%;background:#2563eb">22% Booked</div>
          <div class="pipe-seg" style="width:10%;background:#d97706">10% Reserved</div>
          <div class="pipe-seg" style="width:32%;background:#7c3aed">32% Sold</div>
          <div class="pipe-seg" style="width:2%;background:#dc2626">2%</div>
        </div>
        <div class="unit-legend">
          <div class="legend-item"><div class="legend-dot" style="background:#059669"></div>50 Available</div>
          <div class="legend-item"><div class="legend-dot" style="background:#2563eb"></div>32 Booked</div>
          <div class="legend-item"><div class="legend-dot" style="background:#d97706"></div>15 Reserved</div>
          <div class="legend-item"><div class="legend-dot" style="background:#7c3aed"></div>47 Sold</div>
          <div class="legend-item"><div class="legend-dot" style="background:#dc2626"></div>4 Blocked</div>
        </div>
      </div>
    </div>

    <div class="dash-grid">
      <!-- Monthly Sales Chart -->
      <div class="custom-card">
        <div class="custom-card-header">
          <div class="custom-card-title">Monthly Bookings — 2026</div>
          <div style="display:flex;gap:10px;align-items:center">
            <div style="display:flex;align-items:center;gap:5px;font-size:0.68rem;color:var(--text3)">
              <div style="width:10px;height:10px;border-radius:2px;background:var(--blue)"></div>Bookings
            </div>
            <div style="display:flex;align-items:center;gap:5px;font-size:0.68rem;color:var(--text3)">
              <div style="width:10px;height:10px;border-radius:2px;background:var(--gold)"></div>Revenue (Cr)
            </div>
          </div>
        </div>
        <div class="custom-card-body">
          <div style="display:flex;align-items:flex-end;gap:4px;height:100px;margin-bottom:8px">
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
              <div class="chart-bar" style="height:40%"></div>
              <div class="chart-bar gold" style="height:30%"></div>
              <div style="font-size:0.6rem;color:var(--text3)">Jan</div>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
              <div class="chart-bar" style="height:55%"></div>
              <div class="chart-bar gold" style="height:42%"></div>
              <div style="font-size:0.6rem;color:var(--text3)">Feb</div>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
              <div class="chart-bar" style="height:70%"></div>
              <div class="chart-bar gold" style="height:60%"></div>
              <div style="font-size:0.6rem;color:var(--text3)">Mar</div>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
              <div class="chart-bar" style="height:45%"></div>
              <div class="chart-bar gold" style="height:38%"></div>
              <div style="font-size:0.6rem;color:var(--text3)">Apr</div>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
              <div class="chart-bar" style="height:85%"></div>
              <div class="chart-bar gold" style="height:72%"></div>
              <div style="font-size:0.6rem;color:var(--text3)">May</div>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
              <div class="chart-bar" style="height:60%"></div>
              <div class="chart-bar gold" style="height:50%"></div>
              <div style="font-size:0.6rem;color:var(--text3)">Jun</div>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px">
              <div class="chart-bar" style="height:90%"></div>
              <div class="chart-bar gold" style="height:80%"></div>
              <div style="font-size:0.6rem;color:var(--text3)">Jul</div>
            </div>
          </div>
          <div style="border-top:1px solid var(--parch2);padding-top:10px;display:flex;gap:24px">
            <div><div style="font-size:0.68rem;color:var(--text3)">Total Bookings</div><div style="font-size:1.5rem;font-weight:700;color:var(--navy)">79</div></div>
            <div><div style="font-size:0.68rem;color:var(--text3)">Total Revenue</div><div style="font-size:1.5rem;font-weight:700;color:var(--navy)">৳4.2 Cr</div></div>
            <div><div style="font-size:0.68rem;color:var(--text3)">Avg. Sale Price</div><div style="font-size:1.5rem;font-weight:700;color:var(--navy)">৳53L</div></div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="custom-card">
        <div class="custom-card-header"><div class="custom-card-title">Recent Activity</div></div>
        <div class="custom-card-body" style="padding:12px 18px">
          <div class="timeline">
            <div class="timeline-item">
              <div class="tl-dot" style="background:#d1fae5">✅</div>
              <div class="tl-body">
                <div class="tl-title">Booking confirmed — Unit 5B, Tower A</div>
                <div class="tl-time">Mr. Karim Rahman · 2 hours ago</div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="tl-dot" style="background:#dbeafe">👤</div>
              <div class="tl-body">
                <div class="tl-title">New customer registered</div>
                <div class="tl-time">Ms. Nusrat Jahan · 4 hours ago</div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="tl-dot" style="background:#fef3c7">💳</div>
              <div class="tl-body">
                <div class="tl-title">Installment received — ৳3,50,000</div>
                <div class="tl-time">BK-2026-0031 · 5 hours ago</div>
              </div>
            </div>
            <div class="timeline-item">
              <div class="tl-dot" style="background:#fee2e2">⚠️</div>
              <div class="tl-body">
                <div class="tl-title">Overdue alert — BK-2026-0018</div>
                <div class="tl-time">7 days overdue · Auto-alert sent</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Top Sales Reps -->
    <div class="custom-card">
      <div class="custom-card-header"><div class="custom-card-title">Sales Team Performance</div></div>
      <div class="custom-card-body">
        <table class="data-table">
          <thead>
            <tr>
              <th>Sales Rep</th>
              <th>Leads</th>
              <th>Site Visits</th>
              <th>Bookings</th>
              <th>Revenue Generated</th>
              <th>Conversion Rate</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><div style="display:flex;align-items:center;gap:8px"><div class="lead-rep" style="background:linear-gradient(135deg,#1A56A5,#7c3aed);width:30px;height:30px;font-size:0.68rem">RH</div><div class="td-main">Rafiq Hossain</div></div></td>
              <td>18</td><td>12</td><td>8</td><td style="color:var(--green);font-weight:700">৳42.5L</td>
              <td><span style="color:var(--green);font-weight:700">44%</span></td>
            </tr>
            <tr>
              <td><div style="display:flex;align-items:center;gap:8px"><div class="lead-rep" style="background:linear-gradient(135deg,#059669,#1A56A5);width:30px;height:30px;font-size:0.68rem">SK</div><div class="td-main">Shirin Khanam</div></div></td>
              <td>14</td><td>9</td><td>6</td><td style="color:var(--green);font-weight:700">৳31.8L</td>
              <td><span style="color:var(--green);font-weight:700">43%</span></td>
            </tr>
            <tr>
              <td><div style="display:flex;align-items:center;gap:8px"><div class="lead-rep" style="background:linear-gradient(135deg,#d97706,#dc2626);width:30px;height:30px;font-size:0.68rem">MR</div><div class="td-main">Mahfuz Rahman</div></div></td>
              <td>10</td><td>6</td><td>3</td><td style="color:var(--orange);font-weight:700">৳15.2L</td>
              <td><span style="color:var(--orange);font-weight:700">30%</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</section>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>