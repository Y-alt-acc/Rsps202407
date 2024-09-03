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
  console.log(maxObat + maxBakteri);

  if(values[8][3] && WriteBerdasarkan == "Bakteri")
  {
    ViewWriteBacteria(DataCulSetting, DataCulView, values, 1 ,1 , maxBakteri, maxObat);
  }else{
    ViewWriteObat(DataCulSetting, DataCulView, values, 1 ,1 , maxObat , maxBakteri);
  }
  DataCulView.getRange(3,1).setDataValidation(SpreadsheetApp.newDataValidation().requireValueInList(['*', 'Sputum', 'Darah', 'Urin', 'Feses', 'Swab Dasar Luka/Pus', 'Cairan tubuh lain']).build());
  DataCulView.getRange(3,1).setValue("*");
  DataCulView.getRange(1,3).setValue("Jumlah Isolat");
}
function ViewWriteBacteria(DataCulSetting, DataCulView, values, row, column, maxRow, MaxColumn)
{
  let tolerance = values[3][10] * 2;
  var x = 2;
  let ViewArray = new Array();
  for(let i = 0; i < maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j < tolerance * MaxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  
  for(let i = 0; i < maxRow; i++)
  {
    ViewArray[i+4][1] = DataCulSetting.getRange(i+19,5).getValue();
    ViewArray[i+4][2] = "=COUNTIFS('Data Master'!$I$3:$I,$B"+ (i+5) +",'Data Master'!$G$3:$G,$A$3)";
  }
  for(let i = 0; i < MaxColumn; i++)
  {
    ViewArray[1][i*tolerance+3] = DataCulSetting.getRange(i+52,5).getValue();

    ViewArray[2][i*tolerance+3] = "%Sensitive";
    ViewArray[2][i*tolerance+3+1] = "Total";
  }
  for(let i = 0; i < maxRow; i++)
  {
    for(let j = 0; j < MaxColumn; j++)
    { 
      ViewArray[i+4][j*tolerance+3] = "="+columnToLetter(j*tolerance+5)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
      ViewArray[i+4][j*tolerance+3+1] = "=COUNTIFS('Data Master'!$I$3:$I,$B"+ (i+5) +",'Data Master'!$G$3:$G,$A$3,'Data Master'!$"+columnToLetter(j+10)+"$"+3 + ":$" + columnToLetter(j+10)+",\"S\"";
      // if(true)
      // {
      //   ViewArray[i+4][j*x+3+1] = ViewArray[i+4][j*x+3+1];
      // }
      // if(true)
      // {
      //   ViewArray[i+4][j*x+3+1] = ViewArray[i+4][j*x+3+1];
      // }
      // if(true)
      // {
      //   ViewArray[i+4][j*x+3+1] = ViewArray[i+4][j*x+3+1];
      // }
      // if(true)
      // {
      //   ViewArray[i+4][j*x+3+1] = ViewArray[i+4][j*x+3+1];
      // }
      ViewArray[i+4][j*tolerance+3+1] = ViewArray[i+4][j*tolerance+3+1] +")";
    }
  }
  DataCulView.getRange(row,column,maxRow+5,tolerance * MaxColumn+5).setValues(ViewArray);


}
function ViewWriteObat(DataCulSetting, DataCulView, values, row, column, maxRow, MaxColumn)
{

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