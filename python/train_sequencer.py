import pandas as pd
from sklearn.linear_model import LogisticRegression
import pickle

data = pd.read_csv("training_data.csv")

X = data.drop("label", axis=1)
y = data["label"]

model = LogisticRegression()
model.fit(X, y)

pickle.dump(model, open("sequencer.pkl", "wb"))
