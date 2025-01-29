Step 1: Preliminary Investigation

To begin, I loaded the `world_population.csv` dataset into a Pandas DataFrame (`df`). I looked through the last five rows (`df.tail(5)`), saw the dataset's basic information (`df.info()`), and got descriptive statistics (`df.describe()`) in order to make sense of the data. To ensure the quality of the data, I also counted the number of unique values in each column (`df.nunique()`) and looked for any missing values (`df.isnull().sum()`).

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA!.PNG)

Step 2: Organizing and Illustrating

I sorted the DataFrame based on the `World Population Percentage` column in descending order to determine the top 10 countries by world population percentage. The resulting list is shown here (`df.sort_values(by="World Population Percentage", ascending=False)).The head(10)`.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA2.PNG)

Step 3: Correlation Analysis

In order to investigate the connections among various numerical characteristics, I created a heatmap using the correlation matrix (`sns.heatmap(df.corr(), annot=True)`). I was able to find possible relationships and patterns with the use of this graphic tool.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/eda3.png)

Step 4: Analysis by country (Indonesia)

I zipped in on Indonesia and searched the DataFrame for rows that had the word `Indonesia`. I made a line plot to show population trends over time by selecting pertinent population columns, transposing the data for simpler charting, and creating the figure.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA4.png)

Step 5: Analysis of the Top 5 Countries

I made a bar plot to compare the populations of the top 5 nations in terms of population in 2022. This made the relative sizes of these populous countries easier for me to understand.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA5.png)

Step 6: Analysis by Continent

I found the mean population for each year by dividing the data by continent. Next, a line plot was made to show the trends in population across continents. In addition, I displayed the population data distribution for each continent using a boxplot.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA6.png)

Step 7: Population Aggregation by Continent

I combined the population by continent in order to have a worldwide picture. I made a pie chart to show how the population of the globe would be distributed by region in 2022. Customizations improved the aesthetic appeal and made it simpler to understand the distribution of the world's population.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA7.png)
