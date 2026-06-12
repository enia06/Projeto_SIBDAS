-- BD_Projeto_SIBDAS_DML.sql
-- Dados iniciais para o projeto Stay This.Positive

-- -----------------------------------------------------
-- 1. Tabelas auxiliares
-- -----------------------------------------------------

INSERT INTO categorias (id_categoria, categoria) VALUES
(1, 'Monitorização'),
(2, 'Suporte de vida'),
(3, 'Terapia'),
(4, 'Diagnóstico'),
(5, 'Laboratório'),
(6, 'Esterilização'),
(7, 'Reabilitação');

INSERT INTO tipos_entrada (id_tipo_entrada, tipo_entrada) VALUES
(1, 'Compra'),
(2, 'Doação'),
(3, 'Aluguer'),
(4, 'Empréstimo');

INSERT INTO estados_equipamento (id_estado, estado) VALUES
(1, 'Ativo'),
(2, 'Inativo'),
(3, 'Em manutenção'),
(4, 'Em calibração'),
(5, 'Em quarentena'),
(6, 'Abatido');

INSERT INTO criticidades (id_criticidade, criticidade) VALUES
(1, 'Baixa'),
(2, 'Média'),
(3, 'Alta'),
(4, 'Suporte de vida');

INSERT INTO tipos_fornecedor (id_tipo_fornecedor, tipo_fornecedor) VALUES
(1, 'Fabricante'),
(2, 'Distribuidor/fornecedor comercial'),
(3, 'Empresa de assistência técnica'),
(4, 'Fornecedor de consumíveis/acessórios');

INSERT INTO tipos_documento (id_tipo_documento, tipo_documento) VALUES
(1, 'Manual do Utilizador'),
(2, 'Manual Técnico'),
(3, 'Certificado CE'),
(4, 'Ficha Técnica'),
(5, 'Relatório de Manutenção'),
(6, 'Certificado de Calibração'),
(7, 'Relatório de Inspeção'),
(8, 'Outro');

INSERT INTO estados_garantia (id_estado_garantia, estado_garantia) VALUES
(1, 'Ativa'),
(2, 'A expirar'),
(3, 'Expirada');

INSERT INTO tipos_contrato (id_tipo_contrato, tipo_contrato) VALUES
(1, 'Manutenção preventiva'),
(2, 'Manutenção corretiva'),
(3, 'Manutenção preventiva e corretiva'),
(4, 'Manutenção completa');

INSERT INTO periodicidade (id_periodicidade, periodicidade) VALUES
(1, 'Mensal'),
(2, 'Trimestral'),
(3, 'Semestral'),
(4, 'Anual');

-- -----------------------------------------------------
-- 2. Conteúdos públicos
-- -----------------------------------------------------

INSERT INTO bem_vindo_publico (id_bem_vindo, titulo, descricao, data_criacao, data_ultima_atualizacao) VALUES
(1, 'Bem-vindo à Stay This.Positive', 'Inventário inteligente, saúde para toda a gente.', NOW(), NOW());

INSERT INTO sobre_nos_publico (id_sobre_nos, titulo, descricao, texto_botao, data_criacao, data_ultima_atualizacao) VALUES
(1, 'Quem somos?', 'A Stay This.Positive é uma empresa dedicada à gestão de inventário hospitalar de equipamentos médicos. Disponibilizamos uma plataforma organizada, intuitiva e atualizada para consulta de informação relativa aos equipamentos médicos existentes.', 'Contacte-nos', NOW(), NOW());

INSERT INTO secao_servicos_publico (id_secao_servicos, titulo, data_criacao, data_ultima_atualizacao) VALUES
(1, 'Os nossos serviços', NOW(), NOW());

INSERT INTO servicos_publico (id_servico, icone, titulo, descricao, ordem, ativo, data_criacao, data_ultima_atualizacao, id_secao_servicos) VALUES
(1, 'fa-solid fa-laptop-medical', 'Equipamentos', 'Consulte informações sobre os equipamentos e o seu estado atual.', 1, TRUE, NOW(), NOW(), 1),
(2, 'fa-solid fa-truck-medical', 'Fornecedores', 'Descubra os fornecedores responsáveis pela distribuição dos equipamentos.', 2, TRUE, NOW(), NOW(), 1),
(3, 'fa-solid fa-house-medical-flag', 'Localizações', 'Localize de forma rápida qualquer equipamento nas instalações hospitalares.', 3, TRUE, NOW(), NOW(), 1),
(4, 'fa-solid fa-clipboard-user', 'Documentação técnica', 'Aceda a manuais e documentação técnica dos equipamentos.', 4, TRUE, NOW(), NOW(), 1),
(5, 'fa-solid fa-receipt', 'Garantias e contratos', 'Consulte garantias e contratos associados aos equipamentos.', 5, TRUE, NOW(), NOW(), 1),
(6, 'fa-solid fa-file-waveform', 'Dashboard', 'Acompanhe indicadores relevantes sobre o inventário hospitalar.', 6, TRUE, NOW(), NOW(), 1);

INSERT INTO contactos_publico (id_contacto, titulo, texto_introdutorio, subtitulo_nome, subtitulo_email, subtitulo_mensagem, texto_botao, data_criacao, data_ultima_atualizacao) VALUES
(1, 'Contacto', 'Entre em contacto connosco para esclarecer qualquer dúvida. Estaremos aqui para ajudar!', 'Nome:', 'Email:', 'Mensagem:', 'Enviar', NOW(), NOW());

INSERT INTO rodape_publico (id_rodape, titulo_1, rua, codigo_postal, pais, titulo_2, dias_uteis, sabado_feriados, domingo, titulo_3, email, telefone, instagram, facebook, data_criacao, data_ultima_atualizacao) VALUES
(1, 'Localização', 'Rua dos Engenheiros nº24', '4920-327, Viana do Castelo', 'Portugal', 'Horário', 'Dias úteis (2ª a 6ª feira): 8h - 20h', 'Sábado e feriados: 8h - 13h', 'Domingo: Encerrado', 'Contactos', 'StayThis.Positive@gmail.com', '251 811 722', 'StayThis.Positive', 'StayThis.Positive', NOW(), NOW());

-- -----------------------------------------------------
-- 3. Utilizadores
-- -----------------------------------------------------

INSERT INTO utilizadores (id_utilizador, nome, email, password_hash, perfil, ativo, criado_em) VALUES
(1, 'Administrador', 'admin@staythispositive.pt', '$2y$10$7EqJtq98hPqEX7fNZaFWoOHi/3fYlRW.LwFzO1P3pB9rUjXW0QWmK', 'administrador', TRUE, NOW()),
(2, 'Técnico de Engenharia Clínica', 'tecnico@staythispositive.pt', '$2y$10$7EqJtq98hPqEX7fNZaFWoOHi/3fYlRW.LwFzO1P3pB9rUjXW0QWmK', 'tecnico', TRUE, NOW()),
(3, 'Gestor Hospitalar', 'gestor@staythispositive.pt', '$2y$10$7EqJtq98hPqEX7fNZaFWoOHi/3fYlRW.LwFzO1P3pB9rUjXW0QWmK', 'gestor', TRUE, NOW());

-- -----------------------------------------------------
-- 4. Localizações
-- -----------------------------------------------------

INSERT INTO localizacoes (id_localizacao, codigo, edificio, piso, servico_departamento, acesso, sala_gabinete, responsavel, observacoes) VALUES
(1, 'LOC.001', 'Bloco A', 'Piso 0', 'Urgências', 'Acesso autorizado', 'Sala de Emergência 01', 'Dra. Marta Ferreira', 'Zona de elevada rotação de equipamentos.'),
(2, 'LOC.002', 'Bloco A', 'Piso 1', 'Unidade de Cuidados Intensivos', 'Acesso restrito', 'UCI Box 03', 'Dr. Ricardo Almeida', 'Área crítica com equipamentos de suporte de vida.'),
(3, 'LOC.003', 'Bloco B', 'Piso 2', 'Pediatria', 'Acesso autorizado', 'Enfermaria Pediátrica 02', 'Dra. Inês Rocha', 'Equipamentos adaptados a contexto pediátrico.'),
(4, 'LOC.004', 'Bloco B', 'Piso 1', 'Cardiologia', 'Acesso autorizado', 'Gabinete 12', 'Dr. Paulo Mendes', 'Serviço com equipamentos de diagnóstico cardíaco.'),
(5, 'LOC.005', 'Bloco C', 'Piso 0', 'Radiologia', 'Acesso restrito', 'Sala RX 01', 'Dra. Sofia Martins', 'Sala sujeita a controlo de radiação.'),
(6, 'LOC.006', 'Bloco C', 'Piso 1', 'Imagiologia', 'Acesso restrito', 'Sala Eco 02', 'Dr. João Vieira', 'Sala equipada para exames de imagem.'),
(7, 'LOC.007', 'Bloco D', 'Piso 0', 'Laboratório de Análises Clínicas', 'Acesso autorizado', 'Lab. Bioquímica', 'Dra. Ana Costa', 'Local com equipamentos laboratoriais.'),
(8, 'LOC.008', 'Bloco D', 'Piso 1', 'Farmácia Hospitalar', 'Acesso restrito', 'Sala de Preparação', 'Farm. Rita Lopes', 'Espaço para preparação e controlo de medicamentos.'),
(9, 'LOC.009', 'Bloco E', 'Piso 2', 'Ortopedia', 'Acesso autorizado', 'Gabinete 08', 'Dr. Miguel Santos', 'Área de apoio a tratamentos músculo-esqueléticos.'),
(10, 'LOC.010', 'Bloco E', 'Piso 1', 'Neurologia', 'Acesso autorizado', 'Sala EEG', 'Dra. Helena Ribeiro', 'Sala com equipamentos de avaliação neurológica.'),
(11, 'LOC.011', 'Bloco F', 'Piso 0', 'Esterilização', 'Acesso restrito', 'Central de Esterilização', 'Enf. Carlos Matos', 'Zona de processamento de dispositivos médicos.'),
(12, 'LOC.012', 'Bloco F', 'Piso 1', 'Reabilitação', 'Acesso livre', 'Ginásio Terapêutico', 'Ftm. Beatriz Nunes', 'Área de fisioterapia e recuperação funcional.');

-- -----------------------------------------------------
-- 5. Fornecedores
-- -----------------------------------------------------

INSERT INTO fornecedores (id_fornecedor, codigo, nome_empresa, morada, codigo_postal, nif, contacto_empresa, email, website, pessoa_contacto, telefone_contacto, observacoes, id_tipo_fornecedor) VALUES
(1, 'FOR.001', 'Dräger Portugal', 'Rua Engenheiro Frederico Ulrich, Maia', '4470-605', '500123456', '211554587', 'geral@draeger.pt', 'https://www.draeger.com', 'Rafael Alves', '+351 912 458 731', 'Fornecedor especializado em ventilação, anestesia e monitorização.', 1),
(2, 'FOR.002', 'Philips Healthcare Portugal', 'Avenida D. João II, Lisboa', '1990-084', '501234567', '213456789', 'healthcare@philips.pt', 'https://www.philips.pt/healthcare', 'Mariana Sousa', '+351 934 671 205', 'Fabricante e fornecedor de equipamentos de monitorização e imagem.', 1),
(3, 'FOR.003', 'Medtronic Portugal', 'Lagoas Park, Oeiras', '2740-265', '502345678', '214567890', 'contacto@medtronic.pt', 'https://www.medtronic.com', 'Tiago Moreira', '+351 963 845 127', 'Fornecedor de dispositivos médicos e consumíveis hospitalares.', 2),
(4, 'FOR.004', 'Siemens Healthineers', 'Rua Irmãos Siemens, Amadora', '2720-093', '503456789', '214789123', 'info.pt@siemens-healthineers.com', 'https://www.siemens-healthineers.com', 'Carla Teixeira', '+351 918 572 406', 'Equipamentos de diagnóstico e imagiologia.', 1),
(5, 'FOR.005', 'GE HealthCare Portugal', 'Avenida da República, Lisboa', '1050-191', '504567890', '217654321', 'geral@gehealthcare.pt', 'https://www.gehealthcare.com', 'Nuno Carvalho', '+351 926 104 853', 'Fornecedor de equipamentos de imagem e monitorização.', 2),
(6, 'FOR.006', 'B. Braun Medical', 'Estrada Consiglieri Pedroso, Queluz', '2730-055', '505678901', '214348200', 'info@bbraun.pt', 'https://www.bbraun.pt', 'Patrícia Gomes', '+351 967 352 918', 'Fornecedor de bombas de infusão e consumíveis.', 2),
(7, 'FOR.007', 'Mindray Portugal', 'Rua da Tecnologia, Porto', '4200-135', '506789012', '225123456', 'suporte@mindray.pt', 'https://www.mindray.com', 'Bruno Pires', '+351 914 786 245', 'Fornecedor de monitores, ventiladores e equipamentos laboratoriais.', 2),
(8, 'FOR.008', 'Zoll Medical', 'Avenida da Saúde, Lisboa', '1600-001', '507890123', '218765432', 'info@zoll.pt', 'https://www.zoll.com', 'Diana Marques', '+351 932 517 684', 'Fornecedor de desfibrilhadores e sistemas de emergência.', 1),
(9, 'FOR.009', 'Fresenius Kabi Portugal', 'Rua do Campo Alegre, Porto', '4150-170', '508901234', '226789123', 'info@fresenius-kabi.pt', 'https://www.fresenius-kabi.com', 'Luís Azevedo', '+351 968 241 597', 'Fornecedor de bombas, acessórios e consumíveis clínicos.', 4),
(10, 'FOR.010', 'Olympus Medical Systems', 'Rua Castilho, Lisboa', '1250-071', '509012345', '213987654', 'medical@olympus.pt', 'https://www.olympus.pt', 'Sofia Cardoso', '+351 919 835 472', 'Equipamentos de diagnóstico e endoscopia.', 1),
(11, 'FOR.011', 'Steris Portugal', 'Zona Industrial de Aveiro', '3800-055', '510123456', '234111222', 'info@steris.pt', 'https://www.steris.com', 'André Ferreira', '+351 935 628 104', 'Fornecedor de soluções de esterilização.', 3),
(12, 'FOR.012', 'AssistMed Técnica', 'Rua da Manutenção, Braga', '4700-001', '511234567', '253333444', 'assistencia@assistmed.pt', 'https://www.assistmed.pt', 'Joana Lima', '+351 961 473 825', 'Empresa de assistência técnica multimarca.', 3);

-- -----------------------------------------------------
-- 6. Equipamentos: 30 registos
-- -----------------------------------------------------

INSERT INTO equipamentos (id_equipamento, nome, codigo_interno, numero_serie, marca, modelo, fabricante, ano_fabrico, data_aquisicao, custo_aquisicao, observacoes, id_categoria, id_tipo_entrada, id_estado, id_criticidade, id_localizacao) VALUES
(1, 'Monitor multiparamétrico', '04.002.00', 'MP5-2022-45873', 'Philips', 'IntelliVue MP5', 'Philips Healthcare', 2022, '2023-01-12', 8200.00, 'Monitor com ECG, SpO2, NIBP e temperatura.', 1, 1, 1, 4, 2),
(2, 'Ventilador pulmonar', '05.001.00', 'EV500-2021-9934', 'Dräger', 'Evita V500', 'Dräger', 2021, '2022-03-18', 32500.00, 'Equipamento de suporte ventilatório invasivo e não invasivo.', 2, 1, 1, 4, 2),
(3, 'Bomba de infusão volumétrica', '06.010.00', 'INF-2020-88321', 'B. Braun', 'Infusomat Space', 'B. Braun', 2020, '2021-02-09', 2400.00, 'Bomba utilizada para administração controlada de fluidos.', 3, 1, 1, 2, 3),
(4, 'Desfibrilhador', '07.004.00', 'ZR-2021-7712', 'Zoll', 'R Series', 'Zoll Medical', 2021, '2022-07-25', 14500.00, 'Desfibrilhador com monitorização ECG integrada.', 2, 1, 1, 3, 1),
(5, 'Eletrocardiógrafo', '08.003.00', 'ECG-2022-4410', 'GE HealthCare', 'MAC 2000', 'GE HealthCare', 2022, '2023-04-11', 5200.00, 'Eletrocardiógrafo de 12 derivações.', 4, 1, 1, 3, 4),
(6, 'Ecógrafo portátil', '09.006.00', 'US-2021-8201', 'Siemens', 'Acuson P500', 'Siemens Healthineers', 2021, '2022-10-03', 38500.00, 'Ecógrafo portátil para diagnóstico por imagem.', 4, 1, 1, 3, 6),
(7, 'Centrífuga laboratorial', '10.001.00', 'CF-2020-1129', 'Eppendorf', '5702 R', 'Eppendorf', 2020, '2021-05-14', 7600.00, 'Centrífuga refrigerada para amostras clínicas.', 5, 1, 1, 2, 7),
(8, 'Autoclave hospitalar', '11.002.00', 'AU-2019-3371', 'Steris', 'Amsco 400', 'Steris', 2019, '2020-01-21', 27500.00, 'Autoclave para esterilização de dispositivos médicos.', 6, 1, 1, 3, 11),
(9, 'Analisador bioquímico', '10.005.00', 'AB-2022-0192', 'Mindray', 'BS-240', 'Mindray', 2022, '2023-02-17', 29500.00, 'Analisador automático para bioquímica clínica.', 5, 1, 1, 2, 7),
(10, 'Bomba de seringa', '06.011.00', 'BS-2021-5542', 'Fresenius Kabi', 'Injectomat MC Agilia', 'Fresenius Kabi', 2021, '2022-08-08', 1800.00, 'Bomba de seringa para administração precisa de fármacos.', 3, 1, 1, 2, 8),
(11, 'Monitor de sinais vitais', '04.003.00', 'VS-2020-7751', 'Mindray', 'VS-900', 'Mindray', 2020, '2021-09-16', 3900.00, 'Monitor básico de sinais vitais.', 1, 1, 1, 2, 3),
(12, 'Oxímetro de pulso', '04.004.00', 'OX-2022-6650', 'Masimo', 'Rad-97', 'Masimo', 2022, '2023-03-28', 2100.00, 'Oxímetro portátil com tecnologia de medição contínua.', 1, 1, 1, 2, 1),
(13, 'Aspirador cirúrgico', '06.020.00', 'AS-2019-4420', 'Medela', 'Dominant Flex', 'Medela', 2019, '2020-06-22', 3200.00, 'Aspirador para bloco operatório e urgência.', 3, 1, 3, 2, 1),
(14, 'Cama articulada elétrica', '12.001.00', 'CA-2020-1022', 'Hillrom', 'Centrella', 'Hillrom', 2020, '2021-11-05', 6900.00, 'Cama hospitalar elétrica com comandos laterais.', 7, 1, 1, 1, 9),
(15, 'Equipamento de fisioterapia por ultrassom', '13.003.00', 'FT-2021-9088', 'Enraf-Nonius', 'Sonopuls 490', 'Enraf-Nonius', 2021, '2022-04-19', 2700.00, 'Equipamento usado em tratamentos de reabilitação.', 7, 1, 1, 1, 12),
(16, 'Nebulizador hospitalar', '06.030.00', 'NB-2022-3321', 'Philips', 'InnoSpire Deluxe', 'Philips Healthcare', 2022, '2023-06-07', 450.00, 'Nebulizador para terapêutica respiratória.', 3, 1, 1, 1, 3),
(17, 'Balança médica digital', '14.001.00', 'BM-2020-4477', 'Seca', '769', 'Seca', 2020, '2021-01-30', 680.00, 'Balança digital com estadiómetro.', 4, 1, 1, 1, 3),
(18, 'Laringoscópio', '15.001.00', 'LG-2021-2754', 'Welch Allyn', 'Macintosh', 'Welch Allyn', 2021, '2022-02-10', 850.00, 'Laringoscópio com lâminas reutilizáveis.', 2, 1, 4, 3, 1),
(19, 'Incubadora neonatal', '16.001.00', 'IN-2020-6761', 'Dräger', 'Isolette 8000', 'Dräger', 2020, '2021-07-12', 28500.00, 'Incubadora para cuidados neonatais.', 2, 1, 1, 4, 3),
(20, 'Capnógrafo portátil', '04.005.00', 'CP-2022-1189', 'Medtronic', 'Microstream', 'Medtronic', 2022, '2023-08-02', 4300.00, 'Monitorização de CO2 expirado.', 1, 1, 1, 3, 2),
(21, 'Endoscópio flexível', '09.008.00', 'EN-2021-7402', 'Olympus', 'GIF-HQ190', 'Olympus', 2021, '2022-09-13', 42000.00, 'Endoscópio para exames digestivos.', 4, 1, 5, 3, 6),
(22, 'Aparelho de raios X móvel', '09.010.00', 'RX-2019-3901', 'Siemens', 'Mobilett Mira Max', 'Siemens Healthineers', 2019, '2020-12-16', 68000.00, 'Sistema móvel de radiografia.', 4, 1, 1, 3, 5),
(23, 'Eletroencefalógrafo', '08.020.00', 'EEG-2020-9910', 'Natus', 'NicoletOne', 'Natus', 2020, '2021-10-27', 22500.00, 'Equipamento para exames EEG.', 4, 1, 1, 3, 10),
(24, 'Monitor fetal', '04.006.00', 'MF-2021-3821', 'GE HealthCare', 'Corometrics 250cx', 'GE HealthCare', 2021, '2022-05-04', 9700.00, 'Monitorização fetal e materna.', 1, 1, 1, 3, 3),
(25, 'Unidade eletrocirúrgica', '06.040.00', 'UE-2020-7008', 'Erbe', 'VIO 300D', 'Erbe', 2020, '2021-06-18', 18500.00, 'Unidade eletrocirúrgica para procedimentos clínicos.', 3, 1, 3, 3, 1),
(26, 'Banho-maria laboratorial', '10.010.00', 'BMAR-2022-2256', 'Memmert', 'WNB 14', 'Memmert', 2022, '2023-02-02', 1300.00, 'Equipamento para aquecimento controlado de amostras.', 5, 1, 1, 1, 7),
(27, 'Frigorífico de vacinas', '10.011.00', 'FV-2021-4170', 'Liebherr', 'MKUv 1610', 'Liebherr', 2021, '2022-01-14', 2200.00, 'Frigorífico com controlo de temperatura para vacinas.', 5, 1, 1, 2, 8),
(28, 'Marquesa elétrica', '12.002.00', 'ME-2020-5612', 'Promotal', 'eMotio', 'Promotal', 2020, '2021-09-07', 3100.00, 'Marquesa elétrica para consultas e exames.', 7, 1, 1, 1, 4),
(29, 'Dermatoscópio digital', '08.030.00', 'DD-2022-7863', 'Heine', 'Delta 30 Pro', 'Heine', 2022, '2023-07-21', 1600.00, 'Dermatoscópio digital para observação cutânea.', 4, 1, 2, 1, 4),
(30, 'Sistema de aquecimento de fluidos', '06.050.00', 'AQ-2021-9401', '3M', 'Ranger', '3M Health Care', 2021, '2022-11-29', 4100.00, 'Sistema de aquecimento de fluidos intravenosos.', 3, 1, 1, 2, 1);

-- -----------------------------------------------------
-- 7. Relação N:N equipamento_fornecedor
-- -----------------------------------------------------

INSERT INTO equipamento_fornecedor (id_equipamento, id_fornecedor) VALUES
(1, 2), (1, 12),
(2, 1), (2, 12), (2, 9),
(3, 6), (3, 9),
(4, 8), (4, 12),
(5, 5), (5, 12),
(6, 4), (6, 12),
(7, 12),
(8, 11), (8, 12),
(9, 7), (9, 12),
(10, 9), (10, 12),
(11, 7),
(12, 3),
(13, 12),
(14, 12),
(15, 12),
(16, 2),
(17, 12),
(18, 12),
(19, 1), (19, 12),
(20, 3),
(21, 10), (21, 12),
(22, 4), (22, 12),
(23, 12),
(24, 5),
(25, 12),
(26, 12),
(27, 12),
(28, 12),
(29, 12),
(30, 3), (30, 12);

-- -----------------------------------------------------
-- 8. Documentos associados
-- -----------------------------------------------------

INSERT INTO documentos (id_documento, codigo_documento, nome_localizacao_documento, ficheiro, data_emissao, data_validade, observacoes, id_tipo_documento, id_equipamento, id_fornecedor) VALUES
(1, 'DOC.001', 'Manual do utilizador IntelliVue MP5', 'manual_intellivue_mp5.pdf', '2022-01-10', NULL, 'Documento técnico fornecido pelo fabricante.', 1, 1, 2),
(2, 'DOC.002', 'Manual técnico Evita V500', 'manual_tecnico_evita_v500.pdf', '2021-05-02', NULL, 'Manual de serviço para equipa técnica.', 2, 2, 1),
(3, 'DOC.003', 'Certificado de calibração Infusomat', 'calibracao_infusomat_space.pdf', '2024-01-15', '2025-01-15', 'Calibração anual obrigatória.', 6, 3, 6),
(4, 'DOC.004', 'Relatório de manutenção desfibrilhador', 'manutencao_zoll_rseries.pdf', '2024-03-20', NULL, 'Relatório de manutenção preventiva.', 5, 4, 8),
(5, 'DOC.005', 'Ficha técnica MAC 2000', 'ficha_tecnica_mac2000.pdf', '2022-09-01', NULL, 'Ficha técnica do equipamento.', 4, 5, 5),
(6, 'DOC.006', 'Certificado CE Acuson P500', 'certificado_ce_acuson_p500.pdf', '2021-07-11', NULL, 'Declaração de conformidade CE.', 3, 6, 4),
(7, 'DOC.007', 'Manual centrifuga 5702 R', 'manual_5702r.pdf', '2020-04-22', NULL, 'Manual do utilizador.', 1, 7, NULL),
(8, 'DOC.008', 'Contrato de manutenção autoclave', 'contrato_autoclave_amsco400.pdf', '2023-01-01', '2025-12-31', 'Contrato de manutenção em vigor.', 8, 8, 11),
(9, 'DOC.009', 'Manual analisador BS-240', 'manual_bs240.pdf', '2022-02-19', NULL, 'Manual operacional do analisador.', 1, 9, 7),
(10, 'DOC.010', 'Certificado de calibração bomba de seringa', 'calibracao_injectomat.pdf', '2024-02-12', '2025-02-12', 'Calibração programada anualmente.', 6, 10, 9),
(11, 'DOC.011', 'Relatório de inspeção monitor VS-900', 'inspecao_vs900.pdf', '2024-04-05', NULL, 'Inspeção periódica sem anomalias.', 7, 11, 7),
(12, 'DOC.012', 'Manual oxímetro Rad-97', 'manual_rad97.pdf', '2022-06-30', NULL, 'Manual do utilizador.', 1, 12, NULL),
(13, 'DOC.013', 'Relatório manutenção aspirador', 'manutencao_aspirador.pdf', '2024-03-02', NULL, 'Equipamento em intervenção técnica.', 5, 13, 12),
(14, 'DOC.014', 'Ficha técnica cama Centrella', 'ficha_centrella.pdf', '2020-08-18', NULL, 'Ficha técnica da cama hospitalar.', 4, 14, NULL),
(15, 'DOC.015', 'Manual Sonopuls 490', 'manual_sonopuls490.pdf', '2021-10-09', NequipamentosULL, 'Manual de utilização em fisioterapia.', 1, 15, NULL),
(16, 'DOC.016', 'Manual nebulizador InnoSpire', 'manual_nebulizador_innospire.pdf', '2022-04-14', NULL, 'Manual do utilizador.', 1, 16, 2),
(17, 'DOC.017', 'Ficha técnica balança Seca 769', 'ficha_seca769.pdf', '2020-11-02', NULL, 'Ficha técnica do equipamento.', 4, 17, NULL),
(18, 'DOC.018', 'Relatório calibração laringoscópio', 'calibracao_laringoscopio.pdf', '2024-05-13', '2025-05-13', 'Equipamento em calibração.', 6, 18, 12),
(19, 'DOC.019', 'Manual incubadora Isolette 8000', 'manual_isolette8000.pdf', '2020-09-04', NULL, 'Manual técnico e de utilização.', 1, 19, 1),
(20, 'DOC.020', 'Ficha técnica capnógrafo', 'ficha_microstream.pdf', '2022-12-16', NULL, 'Ficha técnica do equipamento.', 4, 20, 3),
(21, 'DOC.021', 'Relatório inspeção endoscópio', 'inspecao_endoscopio.pdf', '2024-01-28', NULL, 'Equipamento em quarentena até validação.', 7, 21, 10),
(22, 'DOC.022', 'Manual Mobilett Mira Max', 'manual_mobilett_mira.pdf', '2019-10-05', NULL, 'Manual técnico do sistema RX.', 2, 22, 4),
(23, 'DOC.023', 'Manual EEG NicoletOne', 'manual_eeg_nicoletone.pdf', '2020-07-19', NULL, 'Manual de operação.', 1, 23, NULL),
(24, 'DOC.024', 'Certificado CE monitor fetal', 'certificado_ce_corometrics.pdf', '2021-03-21', NULL, 'Declaração CE.', 3, 24, 5),
(25, 'DOC.025', 'Relatório manutenção VIO 300D', 'manutencao_vio300d.pdf', '2024-04-18', NULL, 'Equipamento em manutenção corretiva.', 5, 25, 12),
(26, 'DOC.026', 'Manual banho-maria', 'manual_memmert_wnb14.pdf', '2022-01-15', NULL, 'Manual do equipamento laboratorial.', 1, 26, NULL),
(27, 'DOC.027', 'Registo temperatura frigorífico', 'registo_temperatura_vacinas.pdf', '2024-05-01', '2024-12-31', 'Registo documental para controlo de temperatura.', 8, 27, NULL),
(28, 'DOC.028', 'Ficha técnica marquesa elétrica', 'ficha_marquesa_emotio.pdf', '2020-05-29', NULL, 'Ficha técnica do fabricante.', 4, 28, NULL),
(29, 'DOC.029', 'Manual dermatoscópio Delta 30 Pro', 'manual_dermatoscopio.pdf', '2022-09-09', NULL, 'Manual do utilizador.', 1, 29, NULL),
(30, 'DOC.030', 'Manual sistema Ranger', 'manual_ranger_3m.pdf', '2021-11-18', NULL, 'Manual de utilização do sistema de aquecimento.', 1, 30, 3);

-- -----------------------------------------------------
-- 9. Garantias e contratos
-- -----------------------------------------------------

INSERT INTO garantias_contratos (id_garantia, codigo_garantia, data_inicio, data_fim, existe_contrato, entidade_responsavel, observacoes, id_estado_garantia, id_tipo_contrato, id_periodicidade, id_equipamento) VALUES
(1, 'GAR.001', '2023-01-12', '2026-01-12', TRUE, 'Philips Healthcare Portugal', 'Contrato inclui suporte técnico remoto.', 1, 4, 4, 1),
(2, 'GAR.002', '2022-03-18', '2025-03-18', TRUE, 'Dräger Portugal', 'Garantia associada a contrato de manutenção completa.', 2, 4, 3, 2),
(3, 'GAR.003', '2021-02-09', '2024-02-09', TRUE, 'B. Braun Medical', 'Contrato de manutenção preventiva.', 3, 1, 4, 3),
(4, 'GAR.004', '2022-07-25', '2025-07-25', TRUE, 'Zoll Medical', 'Manutenção preventiva e corretiva.', 1, 3, 3, 4),
(5, 'GAR.005', '2023-04-11', '2026-04-11', TRUE, 'GE HealthCare Portugal', 'Garantia ativa.', 1, 1, 4, 5),
(6, 'GAR.006', '2022-10-03', '2025-10-03', TRUE, 'Siemens Healthineers', 'Contrato preventivo anual.', 1, 1, 4, 6),
(7, 'GAR.007', '2021-05-14', '2024-05-14', FALSE, 'AssistMed Técnica', 'Garantia terminada; assistência pontual.', 3, NULL, NULL, 7),
(8, 'GAR.008', '2020-01-21', '2025-12-31', TRUE, 'Steris Portugal', 'Contrato de manutenção completo.', 1, 4, 3, 8),
(9, 'GAR.009', '2023-02-17', '2026-02-17', TRUE, 'Mindray Portugal', 'Contrato preventivo.', 1, 1, 4, 9),
(10, 'GAR.010', '2022-08-08', '2025-08-08', TRUE, 'Fresenius Kabi Portugal', 'Contrato de calibração e assistência.', 1, 3, 4, 10),
(11, 'GAR.011', '2021-09-16', '2024-09-16', FALSE, 'Mindray Portugal', 'Garantia expirada; sem contrato ativo.', 3, NULL, NULL, 11),
(12, 'GAR.012', '2023-03-28', '2026-03-28', FALSE, 'Medtronic Portugal', 'Garantia do fabricante.', 1, NULL, NULL, 12),
(13, 'GAR.013', '2020-06-22', '2023-06-22', TRUE, 'AssistMed Técnica', 'Equipamento em manutenção.', 3, 2, 3, 13),
(14, 'GAR.014', '2021-11-05', '2024-11-05', FALSE, 'AssistMed Técnica', 'Contrato não renovado.', 3, NULL, NULL, 14),
(15, 'GAR.015', '2022-04-19', '2025-04-19', TRUE, 'AssistMed Técnica', 'Manutenção anual.', 2, 1, 4, 15),
(16, 'GAR.016', '2023-06-07', '2026-06-07', FALSE, 'Philips Healthcare Portugal', 'Garantia ativa sem contrato.', 1, NULL, NULL, 16),
(17, 'GAR.017', '2021-01-30', '2024-01-30', FALSE, 'AssistMed Técnica', 'Garantia expirada.', 3, NULL, NULL, 17),
(18, 'GAR.018', '2022-02-10', '2025-02-10', TRUE, 'AssistMed Técnica', 'Equipamento em calibração.', 3, 1, 4, 18),
(19, 'GAR.019', '2021-07-12', '2025-07-12', TRUE, 'Dräger Portugal', 'Contrato de manutenção preventiva.', 1, 1, 3, 19),
(20, 'GAR.020', '2023-08-02', '2026-08-02', FALSE, 'Medtronic Portugal', 'Garantia ativa.', 1, NULL, NULL, 20),
(21, 'GAR.021', '2022-09-13', '2025-09-13', TRUE, 'Olympus Medical Systems', 'Em quarentena até validação técnica.', 1, 3, 3, 21),
(22, 'GAR.022', '2020-12-16', '2024-12-16', TRUE, 'Siemens Healthineers', 'Contrato anual de assistência.', 3, 3, 4, 22),
(23, 'GAR.023', '2021-10-27', '2024-10-27', TRUE, 'AssistMed Técnica', 'Manutenção preventiva anual.', 3, 1, 4, 23),
(24, 'GAR.024', '2022-05-04', '2025-05-04', TRUE, 'GE HealthCare Portugal', 'Garantia a expirar.', 2, 1, 4, 24),
(25, 'GAR.025', '2021-06-18', '2024-06-18', TRUE, 'AssistMed Técnica', 'Equipamento em manutenção corretiva.', 3, 2, 3, 25),
(26, 'GAR.026', '2023-02-02', '2026-02-02', FALSE, 'AssistMed Técnica', 'Garantia ativa.', 1, NULL, NULL, 26),
(27, 'GAR.027', '2022-01-14', '2025-01-14', TRUE, 'AssistMed Técnica', 'Assistência preventiva semestral.', 3, 1, 3, 27),
(28, 'GAR.028', '2021-09-07', '2024-09-07', FALSE, 'AssistMed Técnica', 'Sem contrato ativo.', 3, NULL, NULL, 28),
(29, 'GAR.029', '2023-07-21', '2026-07-21', FALSE, 'AssistMed Técnica', 'Equipamento inativo, garantia ativa.', 1, NULL, NULL, 29),
(30, 'GAR.030', '2022-11-29', '2025-11-29', TRUE, 'Medtronic Portugal', 'Manutenção preventiva anual.', 1, 1, 4, 30);
