<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-3 pb-5 px-5">
                <div class="mb-4">
                    <h2 class="mb-1">
                        <strong>Dashboard</strong>
                    </h2>
                    <p class="text-muted mt-2 fs-5">
                        Resumo geral sobre os equipamentos médicos
                    </p>
                </div>
                <hr>

                <!-- Indicadores principais -->
                <h5 class="detail-section-title">Estado dos equipamentos</h5>
                <div class="row g-3 mb-5">
                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-laptop-medical dashboard-icon"></i>
                            <h3>128</h3>
                            <p>Total de equipamentos</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-circle-check dashboard-icon"></i>
                            <h3>96</h3>
                            <p>Equipamentos ativos</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-screwdriver-wrench dashboard-icon"></i>
                            <h3>18</h3>
                            <p>Em manutenção</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-circle-xmark dashboard-icon"></i>
                            <h3>14</h3>
                            <p>Equipamentos inativos</p>
                        </div>
                    </div>
                </div>

                <!-- Alertas -->
                <h5 class="detail-section-title">Alertas e indicadores críticos</h5>
                <div class="row g-3 mb-5">
                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong>12</strong>
                            <span>Garantias expiradas</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong>7</strong>
                            <span>Garantias a expirar em 30 dias</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong>15</strong>
                            <span>Sem documentação associada</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong>9</strong>
                            <span>Criticidade elevada</span>
                        </div>
                    </div>
                </div>

                <!-- Tabelas resumo -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Equipamentos por serviço</h5>
                            <table class="table table-bordered align-middle">
                                <thead class="table-header">
                                    <tr>
                                        <th class="text-center">Serviço</th>
                                        <th class="text-center">N.º equipamentos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td class="text-center">Urgências</td><td class="text-center">24</td></tr>
                                    <tr><td class="text-center">UCI</td><td class="text-center">18</td></tr>
                                    <tr><td class="text-center">Cardiologia</td><td class="text-center">15</td></tr>
                                    <tr><td class="text-center">Pediatria</td><td class="text-center">12</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Equipamentos de suporte de vida por serviço</h5>
                            <table class="table table-bordered align-middle">
                                <thead class="table-header">
                                    <tr>
                                        <th class="text-center">Serviço</th>
                                        <th class="text-center">N.º equipamentos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td class="text-center">UCI</td><td class="text-center">10</td></tr>
                                    <tr><td class="text-center">Urgências</td><td class="text-center">8</td></tr>
                                    <tr><td class="text-center">Neurologia</td><td class="text-center">6</td></tr>
                                    <tr><td class="text-center">Pediatria</td><td class="text-center">3</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Distribuição por categoria</h5>
                            <div class="dashboard-pie-container">
                                <canvas id="graficoCategorias" width="220" height="220"></canvas>
                                <div class="dashboard-legend">
                                    <div><span class="legend-1"></span> Monitorização (40%)</div>
                                    <div><span class="legend-2"></span> Suporte de vida (30%)</div>
                                    <div><span class="legend-3"></span> Diagnóstico (20%)</div>
                                    <div><span class="legend-4"></span> Laboratório (10%)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Distribuição por localização</h5>
                            <div class="dashboard-pie-container">
                                <canvas id="graficoLocalizacoes" width="220" height="220"></canvas>
                                <div class="dashboard-legend">
                                    <div><span class="legend-1"></span> Bloco A (50%)</div>
                                    <div><span class="legend-2"></span> Bloco B (30%)</div>
                                    <div><span class="legend-3"></span> Bloco C (10%)</div>
                                    <div><span class="legend-4"></span> Bloco D (10%)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../assets/js/1241327.js"></script>

<?php include '../../includes/footer.php'; ?>

