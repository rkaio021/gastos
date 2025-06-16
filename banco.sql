-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/06/2025 às 22:17
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `cartao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixa`
--

CREATE TABLE `caixa` (
  `id` int(11) NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `data_pagamento` date NOT NULL,
  `id_cartao` int(11) NOT NULL,
  `obs` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartoes`
--

CREATE TABLE `cartoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL COMMENT 'nome do cartão'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cartoes`
--

INSERT INTO `cartoes` (`id`, `nome`) VALUES
(1, 'Inter'),
(2, 'Santander'),
(3, 'Next'),
(4, 'Mercado Pago');

-- --------------------------------------------------------

--
-- Estrutura para tabela `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `local` varchar(100) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_compra` date DEFAULT NULL,
  `parcelado` tinyint(1) NOT NULL DEFAULT 0,
  `parcela_atual` int(11) NOT NULL DEFAULT 1,
  `total_parcelas` int(11) NOT NULL DEFAULT 1,
  `id_cartao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `gastos`
--

INSERT INTO `gastos` (`id`, `descricao`, `local`, `valor`, `data_compra`, `parcelado`, `parcela_atual`, `total_parcelas`, `id_cartao`) VALUES
(10, 'Chave', 'Ribeirão', 150.00, '2025-05-16', 1, 1, 3, 3),
(11, 'Tape/manop', 'Shopee', 137.52, '2025-05-12', 1, 1, 4, 3),
(12, 'Bomba', 'Juatuba', 400.00, '2025-05-14', 1, 1, 4, 3),
(13, 'Insulfilm', 'AudioCar', 239.82, '2025-05-12', 1, 1, 6, 3),
(14, 'Remédio', 'Agropec', 164.91, '2025-05-12', 1, 1, 3, 3),
(15, 'Lavagem', 'Lava-jato', 150.00, '2025-06-17', 0, 1, 1, 3),
(16, 'Corte', 'Lj', 40.00, '2025-06-09', 0, 1, 1, 3),
(17, 'Bota', 'Lancy Country', 484.32, '2025-07-01', 1, 1, 8, 3),
(18, 'Cerveja', 'Escadinha', 5.00, '2025-06-12', 0, 1, 1, 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_caixa_cartao` (`id_cartao`);

--
-- Índices de tabela `cartoes`
--
ALTER TABLE `cartoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gastos_cartao` (`id_cartao`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cartoes`
--
ALTER TABLE `cartoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `caixa`
--
ALTER TABLE `caixa`
  ADD CONSTRAINT `fk_caixa_cartao` FOREIGN KEY (`id_cartao`) REFERENCES `cartoes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `fk_gastos_cartao` FOREIGN KEY (`id_cartao`) REFERENCES `cartoes` (`id`) ON DELETE CASCADE;
COMMIT;
