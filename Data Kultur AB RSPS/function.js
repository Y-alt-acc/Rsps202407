function onEdit(e)
{
  if(e.source.getSheetName() == "View Setting" &&
      (  
        e.range.getColumn() == 3 ||
        e.range.getColumn() == 5 ||
        e.range.getColumn() == 6 ||
        e.range.getColumn() == 7
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

  console.log(DataCulMaster.getName());
  console.log(DataCulSetting.getName());
  console.log(DataCulView.getName());
  let rowi = 1;
  let coli = 1;
}