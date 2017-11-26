
import pandas as pd
import xgboost as xgb
import sys

from sklearn.metrics import confusion_matrix

def preprocess_features(x_all):
	''' Preprocesses the football data and converts catagorical variables into dummy variables. '''
	from sklearn.preprocessing import scale
	cols = [['HTGD','ATGD','HTP','ATP','DiffLP']]
	for col in cols:
		x_all[col] = scale(x_all[col])

	x_all.HM1 = x_all.HM1.astype('str')
	x_all.HM2 = x_all.HM2.astype('str')
	x_all.HM3 = x_all.HM3.astype('str')
	x_all.AM1 = x_all.AM1.astype('str')
	x_all.AM2 = x_all.AM2.astype('str')
	x_all.AM3 = x_all.AM3.astype('str')
	
	# Initialize new output DataFrame
	output = pd.DataFrame(index = x_all.index)

	# Investigate each feature column for the data
	for col, col_data in x_all.iteritems():

		# If data type is categorical, convert to dummy variables
		if col_data.dtype == object:
			col_data = pd.get_dummies(col_data, prefix = col)
					
		# Collect the revised columns
		output = output.join(col_data)

	return output

def read_csv():

	data = pd.read_csv('final_dataset.csv')


	data = data[data.MW > 3]
	data.drop(['Unnamed: 0','HomeTeam', 'AwayTeam', 'Date', 'MW', 'HTFormPtsStr', 'ATFormPtsStr', 'FTHG', 'FTAG',
			   'HTGS', 'ATGS', 'HTGC', 'ATGC','HomeTeamLP', 'AwayTeamLP','DiffPts','HTFormPts','ATFormPts',
			   'HM4','HM5','AM4','AM5','HTLossStreak5','ATLossStreak5','HTWinStreak5','ATWinStreak5',
			   'HTWinStreak3','HTLossStreak3','ATWinStreak3','ATLossStreak3'],1, inplace=True)
	return data



def train_test(data):

	x_all = data.drop(['FTR'],1)
	y_all = data['FTR']

	x_all = preprocess_features(x_all)

	# print x_all.columns.values

	from sklearn.model_selection import train_test_split

	x_train, x_test, y_train, y_test = train_test_split(x_all, y_all, test_size=1.0/10,random_state=0,stratify=y_all)

	clf = xgb.XGBClassifier(seed = 82)
	clf.fit(x_train, y_train)

	y_pred=clf.predict(x_test)

	cm=confusion_matrix(y_test,y_pred)

	# print cm

	return clf

def predict(clf,df):

	y_pred=clf.predict(df)
	return y_pred

def make_df():

	x_all=pd.DataFrame()

	col=['HTP','ATP','HM1','HM2','HM3','AM1','AM2','AM3','HTGD','ATGD','DiffFormPts','DiffLP']

	for i in range(1,len(sys.argv)):
		x_all[col[i-1]]=[sys.argv[i]]
	
	from sklearn.preprocessing import scale
	cols = [['HTGD','ATGD','HTP','ATP','DiffLP']]
	for col in cols:
		x_all[col] = scale(x_all[col])

	x_all.HM1 = x_all.HM1.astype('str')
	x_all.HM2 = x_all.HM2.astype('str')
	x_all.HM3 = x_all.HM3.astype('str')
	x_all.AM1 = x_all.AM1.astype('str')
	x_all.AM2 = x_all.AM2.astype('str')
	x_all.AM3 = x_all.AM3.astype('str')

	dummies=['HM1','HM2','HM3','AM1','AM2','AM3']

	for dummy in dummies:

		if x_all[dummy][0]=='D':

			x_all[dummy+'_D']=1
			x_all[dummy+'_L']=0
			x_all[dummy+'_W']=0

		elif x_all[dummy][0]=='L':

			x_all[dummy+'_D']=0
			x_all[dummy+'_L']=1
			x_all[dummy+'_W']=0

		elif x_all[dummy][0]=='W':

			x_all[dummy+'_D']=0
			x_all[dummy+'_L']=0
			x_all[dummy+'_W']=1

		elif x_all[dummy][0]=='M':

			x_all[dummy+'_D']=0
			x_all[dummy+'_L']=0
			x_all[dummy+'_W']=0

	for dummy in dummies:

		del x_all[dummy]

	for col in list(x_all.columns.values):
		x_all[col]=x_all[col].astype(float)

	neworder=['HTP', 'ATP', 'HM1_D', 'HM1_L', 'HM1_W', 'HM2_D', 'HM2_L', 'HM2_W', 'HM3_D',
 'HM3_L', 'HM3_W', 'AM1_D', 'AM1_L', 'AM1_W', 'AM2_D', 'AM2_L', 'AM2_W', 'AM3_D',
 'AM3_L', 'AM3_W', 'HTGD', 'ATGD', 'DiffFormPts', 'DiffLP']

 	df=pd.DataFrame()

 	for order in neworder:
 		df[order]=x_all[order]

 	# print df.columns.values

	return df
		

if __name__=='__main__':

	data=read_csv()
	clf=train_test(data)

	if len(sys.argv)==13:
		df=make_df()
		y_pred=predict(clf,df)
		print y_pred
	else:
		print "invalid parameters"
