ALTER TABLE `ci_stakeholders` ADD `strategy_id` INT(11) NOT NULL FIRST, ADD INDEX `strategy_id_stakeholders` (`strategy_id`);
ALTER TABLE `ci_stakeholder_comments` ADD `strategy_id` INT(11) NOT NULL FIRST, ADD INDEX `strategy_id_stakeholder_comments` (`strategy_id`);
Update `ci_stakeholders` set strategy_id = 1;
Update `ci_stakeholder_comments` set strategy_id = 1;

CREATE TABLE `ci_strategies` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_strategies`
--
ALTER TABLE `ci_strategies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_strategies`
--
ALTER TABLE `ci_strategies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
