1. The php file fridge.php file needs to be run. It directly loads the csv and json file already available in the folder

2. fridge.csv file contains the fridge data in the csv format which is imported in the read_csv function.

3. recipe.json file contians recipes which is imported in findRecipe function.

4. Add csv or json file with the above names to run with different dataset.

5. As per the data given in the fridge csv mixed salad is already expired(26/12/2016) so this recipe cannot be printed.
Note: In question set it written that salad sandwich needs to be printed but thats not possible as mixed salad is already expired.

6. I have created a Fridge class for having a object instance of every item in the fridge which then I have used to compare it with recipe data. I found this more easy than to create a array and compare as this would create very messy code.

7. I faced bit difficulty while comparing the items according to the useby date as php deals with the date very different. I had to create a new format which I would be able to use for comparison.

8. 
