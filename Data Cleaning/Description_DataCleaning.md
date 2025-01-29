1. Data Loading:
   - I began by using Pandas to load the FIFA21 dataset from the CSV file.
   - To get a preliminary perspective, examine the first five rows using `data.head(5)`.
   - To improve comprehension, I used `data.info()` to verify data types and missing values.
```
import pandas as pd
data=pd.read_csv('/content/fifa21 raw data v2.csv')

```

```
data.info()
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning1.PNG)

2. Columns for Handling:
   - At indices 3, 4, and 18, superfluous columns were removed with the help of `data.drop(data.columns[[3, 4, 18]], axis=1, inplace=True)`.
   - Zeros were used to fill in the missing values in the "Hits" column: `data['Hits'].fillna(0, inplace=True)`.

![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning2.PNG)

3. Formatting and Renaming Columns:
   - Used `data=data.rename(columns={'LongName':'FullName'})` to rename the 'LongName' column to 'FullName'.
   - Changed the format of the 'Joined' column to a datetime format ('YYYY-MM-DD').
   - The '↓OVA' column has been renamed to 'OVA'.
   - The 'Club' column's extraneous characters were eliminated.
  
```
data['Joined'] = pd.to_datetime(data['Joined'], format='%b %d, %Y')

data['Joined'] = data['Joined'].dt.strftime('%Y-%m-%d')
```


4. Managing Player Status:
   - 'on_loan' and 'free' columns were added to record certain player statuses.
   - Based on the updated status indicators, modified the 'Status' column.
  
```
data['on_loan'] = data['Joined'].str.contains('On Loan')

data['free'] = data['Joined'].str.contains('Free')

data['Joined'] = data['Joined'].str.replace('On Loan', '').str.replace('Free', '').str.strip()

data['Status'] = 'active'
data.loc[data['on_loan'], 'Status'] = 'on loan'
data.loc[data['free'], 'Status'] = 'free'
```

5. Rearranging Columns:
   - The columns were rearranged to improve readability.
   - The 'Contract' column format was standardized.
   - The dataset's final three columns were eliminated.

```
new_order = list(data.columns[:9]) + ['Status'] + list(data.columns[9:])
data = data[new_order]
data.drop(data.iloc[:,-3:],axis=1,inplace=True)
```

6. Height and Weight Standardization:
    - Converted the columns for height and weight to a single unit (kilograms for weight and centimeters for height).
  
```
import re

def convert_height_to_cm(height):
    if 'cm' in height:
        cm_value = int(re.search(r'\d+', height).group())
        return cm_value
    else:
        feet, inches = map(int, re.findall(r'\d+', height))
        total_inches = feet * 12 + inches
        total_centimeters = total_inches * 2.54
        return total_centimeters

data['Height'] = data['Height'].apply(convert_height_to_cm)
```
```
def convert_weight_to_kg(weight):
    if 'kg' in weight:
        kg_value = int(re.search(r'\d+', weight).group())
        return kg_value
    elif 'lbs' in weight:
        lbs_value = int(re.search(r'\d+', weight).group())
        kg_value = lbs_value * 0.45359237
        return kg_value
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning5.PNG)

7. Monetary Values Conversion:
   - Took numeric values in euros for the "Release Clause," "Wage," and "Value" columns.

```
def convert_to_numeric(converto):
    numeric_value = 0  # Default value

    if isinstance(converto, str):
        if 'M' in converto:
            match = re.search(r'\d+\.\d+', converto)
            numeric_value = float(match.group()) * 1e6 if match else 0
        elif 'K' in converto:
            match = re.search(r'\d+', converto)
            numeric_value = float(match.group()) * 1e3 if match else 0
    elif isinstance(converto, (int, float)):
        numeric_value = float(converto)

    return '{:.0f}'.format(numeric_value)
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning3.PNG)

8. Numeric Consistency:
   - To guarantee consistent numerical representation, star symbols were eliminated from the 'IR', 'SM', and 'W/F' columns.
   - Made certain columns into integers ('Hits', 'W/F', 'SM', 'IR').

```
data_types = {
    'Value(€)': 'int64',
    'Wage(€)': 'int64',
    'Release Clause(€)': 'int64',
    'Hits': 'int64',
    'W/F': 'int64',
    'SM': 'int64',
    'IR': 'int64'
}

data = data.astype(data_types)
```

9. Sorting and Cleaning Positions:
    - By sorting the positions within each entry alphabetically, I was able to sort and clean the 'Positions' column.

```
def sort_row(row):
    return ', '.join(sorted(row.split(', ')))

data['Positions'] = data['Positions'].apply(sort_row)
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning4.PNG)

10. Saving the Cleaned Data:
    - Used `data.to_csv('cleaned fifa21.csv')} to save the cleaned dataset to a new CSV file called 'cleaned fifa21.csv'.

```
data.to_csv('cleaned fifa21.csv')
```
