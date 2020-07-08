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

ALTER TABLE `ci_strategies` ADD `description` TEXT NOT NULL AFTER `name`;

--set all descriptions to be the one for DFAT as a starting point
update ci_strategies set description = '        <div class="header">             <h1>AeRO APAN COVID19 Response</h1>             <h2>An eResearch response for Southeast Asia</h2>         </div>          <div class="content">                       <h2 class="content-subhead">An introduction to this response</h2>             <p>                 The COVID-19 virus threatens the stability and prosperity of Australia and it’s high priority Southeast                 Asian partners. We propose a strategic and tactical support to these partners to help address inequities in                 medical research capability and capacity. Given the situation this project will have to be a combination of                 a discovery and activity phase. This means that we will have to treat this project in an agile way and have                 principles to help us guide our decision making. The five principal benefits that this project is able to                 deliver:                 <ol>                     <li>Mutually beneficial outcomes across COVID-19 research communities in Southeast Asia in terms of e-Infrastructure (compute time, software/data management support and training as other resources related to High Performance Computing (HPC) machines). </li> <li>Transparent and accountable as possible in bringing together government, industry and academic organisations both in Australia and in Southeast Asia. A survey of advanced computational and related upskilling needs of institutions working on COVID-19 research will be carried out together with consultations with partner governments and other stakeholders in Southeast Asia to identify priorities.</li> <li>Training according to prioritised partner needs to manage &quot;big data&quot;, data standards and other skills relating to High Performance Data (HPD) as well as in optimising programming and management skills in the use of High Performance Computing (HPC) facilities</li> <li>Build cross-country relationships for future and lasting collaboration through promotion of study/training and post-doctoral/early research opportunities in Australia.</li> <li>Prioritise opportunities that can promote women in the education, research and industry workplaces.</li>                 </ol>             </p></div>';

