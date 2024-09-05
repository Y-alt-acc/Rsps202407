function onEdit(e)
{
  if(e.source.getSheetName() == "View Setting" &&
      (  
        e.range.getColumn() == 3 ||
        e.range.getColumn() == 4 ||
        e.range.getColumn() == 6 ||
        e.range.getColumn() == 7 ||
        e.range.getColumn() == 8
      )
    )
  {
    ViewSettingChangeCheck(e);
  }
}
function ViewSettingChangeCheck(e)
{
  DataCulMaster = e.source.getSheetByName("Data Master");
  if( DataCulMaster)
  {
    DataCulSetting = e.source.getSheetByName("View Setting");
    DataCulView = e.source.getSheetByName("view");
    if(DataCulView == null)
    {
      DataCulView = e.source.insertSheet("view");
    }
    ViewSettingChange(DataCulMaster,DataCulSetting, DataCulView);
  }
  
}
function ViewSettingChange(DataCulMaster,DataCulSetting, DataCulView)
{
  let row = 1;
  let column = 1;
  let numRows = 20;
  let numColumn = 11;

  let range = DataCulSetting.getRange(row, column, numRows, numColumn);
  let values = range.getValues();
  let WriteBerdasarkan = values[8][5];
  let maxObat = values[8][10];
  let maxBakteri = values[5][10];
  let sorting = new Array();
  let maxSorting = 1;
  let tolerance = values[3][10] * 2;
  let boolsorting = "TRUE";
  if(values[3][5] == "Naik")
  {
    boolsorting = "TRUE";
  }else{
    boolsorting = "FALSE";
  }
  DataCulView.clear();
  if(values[8][3] && WriteBerdasarkan == "Bakteri")
  {
    ViewWriteBacteria(DataCulSetting, DataCulView, values, 1 ,1 , maxBakteri, maxObat);
    if(values[3][3])
    {
      DataCulView.getRange(maxBakteri + 7,4).setValue("=Transpose(SORT(Transpose(D1:"+columnToLetter(maxObat*tolerance+3)+(maxBakteri+4)+"),A2,"+boolsorting+"))");
      DataCulView.getRange(maxBakteri +7, 2,maxBakteri  + 4).setValues(DataCulView.getRange(1,2,maxBakteri+4).getValues());
      DataCulView.getRange(maxBakteri +7, 3,maxBakteri  + 4).setValues(DataCulView.getRange(1,3,maxBakteri+4).getFormulas());
      DataCulView.getRange(maxBakteri + 7,2).setValue("Sort By");
      DataCulView.getRange(maxBakteri + 8,2).setValue("=INDIRECT(CONCATENATE(\"B\",A2))");
    }
    maxSorting = maxBakteri;

  }else{
    ViewWriteObat(DataCulSetting, DataCulView, values, 1 ,1 , maxObat , maxBakteri);
    if(values[3][3])
    {
      DataCulView.getRange(maxObat*tolerance + 7,4).setValue("=Transpose(SORT(Transpose(E1:"+columnToLetter(maxBakteri+4)+(maxObat*tolerance+3)+"),A2,"+boolsorting+"))");
      DataCulView.getRange(maxObat*tolerance +7, 2,maxObat*tolerance  + 4,2).setValues(DataCulView.getRange(1,2,maxObat*tolerance+4,2).getValues());
    }
    maxSorting = maxObat*tolerance;
    if(maxSorting>500){
      maxSorting = 499;
    }
  }
  DataCulView.getRange(1,1).setValue("Urutan");

  DataCulView.getRange(3,1).setDataValidation(SpreadsheetApp.newDataValidation().requireValueInList(['*', 'Sputum', 'Darah', 'Urin', 'Feses', 'Swab Dasar Luka/Pus', 'Cairan tubuh lain']).build());
  DataCulView.getRange(3,1).setValue("*");
  
  for(let i = 0; i < maxSorting;i++)
  {
    sorting[i] = i+5;
  }
  DataCulView.getRange(2,1).setDataValidation(SpreadsheetApp.newDataValidation().requireValueInList(sorting).build());
  DataCulView.getRange(2,1).setValue("5");
  DataCulView.autoResizeColumn(2);
  DataCulView.setFrozenColumns(3);
  DataCulView.setFrozenRows(3);
}

function ViewWriteBacteria(DataCulSetting, DataCulView, values, row, column, maxRow, MaxColumn)
{
  let tolerance = values[3][10] * 2;
  let k = 0;
  let ViewArray = new Array();
  for(let i = 0; i < maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j < tolerance * MaxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  for(let i = 0, l = 0; i < maxRow;)
  {
    if(DataCulSetting.getRange(i+l+19,4).getValue())
    {
      ViewArray[i+4][1] = DataCulSetting.getRange(i+l+19,5).getValue();
      if(values[2][3])
      {
        if(values[2][5] == "Termasuk")
        {
          ViewArray[i+4][2] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3"+ ViewSortAdd(values);
        }else{
          ViewArray[i+4][2] ="=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3) - COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3" +ViewSortAdd(values);  
        }
      }else{
        ViewArray[i+4][2] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3)";
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0, l = 0; i < MaxColumn;)
  {
    k = 3;
    if(DataCulSetting.getRange(i+ l +52,4).getValue()){
      if(values[15][3]){
        ViewArray[1][i*tolerance+k] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[1][i*tolerance+k+1] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[2][i*tolerance+k] = "%Sensitive";
        ViewArray[2][i*tolerance+k+1] = "Total";
        k+=2;
      }
      if(values[16][3]){
        ViewArray[1][i*tolerance+k] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[1][i*tolerance+k+1] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[2][i*tolerance+k] = "%Intermediate";
        ViewArray[2][i*tolerance+k+1] = "Total";
        k+=2;
      }
      if(values[17][3]){
        ViewArray[1][i*tolerance+k] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[1][i*tolerance+k+1] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[2][i*tolerance+k] = "%Resistensi";
        ViewArray[2][i*tolerance+k+1] = "Total";
        k+=2;
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0; i < maxRow; i++)
  {
    for(let j = 0; j < MaxColumn; j++)
    {
      k = 3; 
      if(values[15][3]){
        ViewArray[i+4][j*tolerance+k] = "="+columnToLetter(j*tolerance+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
        ViewArray[i+4][j*tolerance+k+1] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(j+12)+"$"+3 + ":$" + columnToLetter(j+12)+",\"S\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[16][3]){
        ViewArray[i+4][j*tolerance+k] = "="+columnToLetter(j*tolerance+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
        ViewArray[i+4][j*tolerance+k+1] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(j+12)+"$"+3 + ":$" + columnToLetter(j+12)+",\"I\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[17][3]){
        ViewArray[i+4][j*tolerance+k] = "="+columnToLetter(j*tolerance+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
        ViewArray[i+4][j*tolerance+k+1] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(j+12)+"$"+3 + ":$" + columnToLetter(j+12)+",\"R\""+ ViewSortAdd(values);
        k+=2;
      }
    }
  }
  ViewArray[0][2] = "Jumlah Isolat";
  ViewArray[3][0] = "=COUNTIF('Data Master'!$H$3:$H,$A$3)";
  DataCulView.getRange(row,column,maxRow+5,tolerance * MaxColumn+5).setValues(ViewArray);


}
function ViewWriteObat(DataCulSetting, DataCulView, values, row, column, maxRow, MaxColumn)
{
  let tolerance = values[3][10] * 2;
  let k = 0;
  let ViewArray = new Array();
  for(let i = 0; i < tolerance *maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j <  MaxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  for(let i = 0, l = 0; i < maxRow;)
  {
    k = 4;
    if(DataCulSetting.getRange(i+ l +52,4).getValue()){
        ViewArray[i*tolerance+k][1] = DataCulSetting.getRange(i+ l +52,5).getValue();
      if(values[15][3]){
        ViewArray[i*tolerance+k][2] = "%Sensitive";
        ViewArray[i*tolerance+k+1][2] = "Total";
        k+=2;
      }
      if(values[16][3]){
        ViewArray[i*tolerance+k][2] = "%Intermediate";
        ViewArray[i*tolerance+k+1][2] = "Total";
        k+=2;
      }
      if(values[17][3]){
        ViewArray[i*tolerance+k][2] = "%Resistensi";
        ViewArray[i*tolerance+k+1][2] = "Total";
        k+=2;
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0, l = 0; i < MaxColumn;)
  {
    if(DataCulSetting.getRange(i+l+19,4).getValue())
    {
      ViewArray[1][i+4] = DataCulSetting.getRange(i+l+19,5).getValue();
      if(values[2][3])
      {
        if(values[2][5] == "Termasuk")
        {
          ViewArray[2][i+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3"+ ViewSortAdd(values);
        }else{
          ViewArray[2][i+4] ="=COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3) - COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3" +ViewSortAdd(values);  
        }
      }else{
        ViewArray[2][i+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3)";
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0; i < maxRow; i++)
  {
    for(let j = 0; j < MaxColumn; j++)
    {
      k = 4; 
      if(values[15][3]){
        ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
        ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"S\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[16][3]){
        ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
        ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"I\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[17][3]){
        ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
        ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"R\""+ ViewSortAdd(values);
        k+=2;
      }
    }
  }
  DataCulView.getRange(row,column,tolerance * maxRow+5, MaxColumn+5).setValues(ViewArray);
}
function ViewSortAdd(values)
{
  let StringAdd = "";
  let leftCompareSign = "";
  let rightCompareSign = "";
  if(values[4][3])
  {
    if(values[4][5] == "Luar")
    {
      leftCompareSign = "<";
      rightCompareSign = ">";
    }else{
      leftCompareSign = ">";
      rightCompareSign = "<";
    }
    StringAdd = StringAdd + ",'Data Master'!$F$3:$F,\"" + leftCompareSign +"\" & 'View Setting'!$G$5"+ ",'Data Master'!$F$3:$F,\"" + rightCompareSign +"\" & 'View Setting'!$H$5";
  }
  if(values[5][3])
  {
    StringAdd = StringAdd + ",'Data Master'!$D$3:$D,\"" +values[5][5]+"\"";
  }
  if(values[6][3])
  {
    if(values[6][5] == "Luar")
    {
      leftCompareSign = "<";
      rightCompareSign = ">";
    }else{
      leftCompareSign = ">";
      rightCompareSign = "<";
    }
    StringAdd = StringAdd + ",'Data Master'!$C$3:$C,\"" + leftCompareSign +"\" & 'View Setting'!$G$7"+ ",'Data Master'!$C$3:$C,\"" + rightCompareSign +"\" & 'View Setting'!$H$7";
  }
  if(values[7][3])
  {
    StringAdd = StringAdd + ",'Data Master'!$I$3:$I,\"" +values[7][5]+"\"";
  }
  StringAdd = StringAdd + ")";
  return StringAdd;
}
function columnToLetter(column)
{
  var temp, letter = '';
  while (column > 0)
  {
    temp = (column - 1) % 26;
    letter = String.fromCharCode(temp + 65) + letter;
    column = (column - temp - 1) / 26;
  }
  return letter;
}

function letterToColumn(letter)
{
  var column = 0, length = letter.length;
  for (var i = 0; i < length; i++)
  {
    column += (letter.charCodeAt(i) - 64) * Math.pow(26, length - i - 1);
  }
  return column;
}